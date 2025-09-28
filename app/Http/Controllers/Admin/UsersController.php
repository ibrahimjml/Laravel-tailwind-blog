<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\{CreateUserRequest, UpdateUserRequest};
use App\Models\{Permission, Role, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
     public function __construct(){
        $this->middleware('permission:user.view')->only('users');
        $this->middleware('permission:user.create')->only('createUser');
        $this->middleware('permission:user.edit')->only('updateUser');
        $this->middleware('permission:user.block')->only('toggle');
        $this->middleware('permission:user.role')->only('role');
        $this->middleware('permission:user.delete')->only('destroy');
     }
      public function users(Request $request)
  {
    $blocked = (bool) $request->get('blocked', false);

  $users = User::with(['roles','roles.permissions','userPermissions']) 
                ->withCount(['reportsSubmitted', 'reportsReceived'])
               ->latest()
               ->search($request->only('search'))
               ->when($blocked, fn($q) => $q->where('is_blocked', 1))
               ->paginate(6)
               ->withQueryString();
    $roles = Role::all();
    return view('admin.users.users',[
      'users'=>$users,
      'filter'=>$request->only(['search','blocked']),
      'permissions' => Permission::all()->groupBy('module'),
      'roles'=>$roles
    ]);
  }
public function createUser(CreateUserRequest $request)
{
 $fields = $request->validated();

   $fields['password'] = Hash::make($fields['password']);
  $user = User::create($fields);
    
        $user->roles()->sync($fields['roles']);
       $newRole = Role::find($fields['roles']);

        if ($newRole && $newRole->name === 'User') {
            $user->userPermissions()->sync($request->permissions ?? []);
        } else {
            $user->userPermissions()->detach();
        }
    toastr()->success('user created',['timeOut'=>1000]);
    return back();
}
public function updateUser(UpdateUserRequest $request, User $user)
{
    $fields = $request->validated();

   if (!empty($fields['password'])) {
        $fields['password'] = Hash::make($fields['password']);
    } else {
        unset($fields['password']);
    }
    $user->update($fields);
  
     if (isset($fields['roles'])) {
        $user->roles()->sync([$fields['roles']]);
        $newRole = Role::find($fields['roles']);

        if ($newRole && $newRole->name === 'User') {
            $user->userPermissions()->sync($request->permissions ?? []);
        } else {
            $user->userPermissions()->detach();
        }
    }
    
      toastr()->success('user updated',['timeOut'=>1000]);
    return back();
}
  
  public function toggle(User $user){
    $this->authorize('block',$user);
    $user->update(['is_blocked' => !$user->is_blocked]);
    if($user->is_blocked){
    toastr()->success('user blocked success',['timeOut'=>1000]);
  }else{
      toastr()->success('user unblocked success',['timeOut'=>1000]);
  }
      return redirect()->back();
  }

  public function destroy(User $user){
  
    
    $this->authorize('delete',$user);
    $user->delete();
    toastr()->success('user deleted',['timeOut'=>1000]);
    return back();
  }
  public function role(Request $request,User $user)
  {
    $this->authorize('role',$user);
    $fields= $request->validate([
      'role'=>'required|exists:roles,name'
    ]);
  
     $role = Role::where('name', $fields['role'])->first();
    $user->roles()->sync([$role->id]);
    toastr()->success("user role '{$fields['role']}' updated",['timeOut'=>1000]);
   return back();
  }
}
