<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Admin\CreateUserDTO;
use App\DTOs\Admin\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\{CreateUserRequest, UpdateUserRequest};
use App\Models\{Permission, Role, User};
use App\Services\Admin\UsersService;
use Illuminate\Http\Request;


class UsersController extends Controller
{
     public function __construct(private UsersService $service){
        $this->middleware('permission:user.view')->only('users');
        $this->middleware('permission:user.create')->only('createUser');
     }
      public function users(Request $request)
  {
    $users = $this->service->getUsers($request->only('search','blocked','sort'));
    $roles = Role::all();
    return view('admin.users.users',[
      'users'=>$users,
      'filter'=>$request->only(['search','blocked','sort']),
      'permissions' => Permission::all()->groupBy('module'),
      'roles'=>$roles
    ]);
  }
public function createUser(CreateUserRequest $request)
{
    $dto = CreateUserDTO::fromRequest($request);
    $this->service->createUser($dto);

    toastr()->success('user created',['timeOut'=>1000]);
    return back();
}
public function updateUser(UpdateUserRequest $request, User $user)
{     $this->authorize('updateAny',$user);
      $dto = UpdateUserDTO::fromRequest($request);
      $this->service->updateUser($user,$dto);

      toastr()->success('user updated',['timeOut'=>1000]);
      return back();
}
  
  public function toggle(User $user){
    
    $this->authorize('block',$user);
    $this->service->toggleStatus($user);
    
    $message = $user->fresh()->is_blocked ? 'User blocked successfully' : 'User unblocked successfully';
    
    toastr()->success($message,['timeOut'=>1000]);
    return redirect()->back();
  }

  public function destroy(User $user){

    $this->authorize('deleteAny',$user);
     $this->service->deleteUser($user);

    toastr()->success('user deleted',['timeOut'=>1000]);
    return back();
  }
  public function role(Request $request,User $user)
  {
    $this->authorize('role',$user);

    $fields= $request->validate([
      'role'=>['required','exists:roles,name']
    ]);
    
    $this->service->changeRole($user, $fields['role']);
    
    toastr()->success("user role '{$fields['role']}' updated",['timeOut'=>1000]);
    return back();
  }
}
