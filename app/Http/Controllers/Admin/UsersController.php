<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Admin\CreateUserDTO;
use App\DTOs\Admin\UpdateUserDTO;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\{CreateUserRequest, UpdateUserRequest};
use App\Models\{Permission, Role, User};
use App\Services\Admin\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class UsersController extends Controller
{
     public function __construct(private UsersService $service){
        $this->middleware('permission:user.view')->only('users');
        $this->middleware('permission:user.create')->only('createUser');
        $this->middleware('permission:user.edit')->only('updateUser');
        $this->middleware('permission:user.block')->only('toggle');
        $this->middleware('permission:user.role')->only('role');
        $this->middleware('permission:user.delete')->only('destroy');
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
{
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

    $this->authorize('delete',$user);
     $this->service->deleteUser($user);

    toastr()->success('user deleted',['timeOut'=>1000]);
    return back();
  }
  public function role(Request $request,User $user)
  {
    $this->authorize('role',$user);

    $fields= $request->validate([
      'role'=>['required', new Enum(UserRole::class)]
    ]);
    
    $this->service->changeRole($user, UserRole::from($fields['role']));
    
    toastr()->success("user role '{$fields['role']}' updated",['timeOut'=>1000]);
    return back();
  }
}
