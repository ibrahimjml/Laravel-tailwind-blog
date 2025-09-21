<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\CreatePostDTO;
use App\Http\Requests\App\CreatePostRequest;
use App\Models\Hashtag;
use App\Models\Permission;
use App\Models\Post;
use App\Models\User;
use App\Services\Admin\DashboardStatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CreateUserRequest;
use App\Http\Requests\App\Admin\UpdateUserRequest;
use App\Models\Category;
use App\Models\PostReport;
use App\Models\Role;
use App\Services\PostService;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(protected DashboardStatsService $stats)
  {

    $this->middleware('permission:user.view')->only('users');
    $this->middleware('permission:user.create')->only('createuser');
    $this->middleware('permission:user.edit')->only('updateuser');
    $this->middleware('permission:user.block')->only('toggle_block');
    $this->middleware('permission:user.role')->only('role');
    $this->middleware('permission:user.delete')->only('destroy');
    $this->middleware('permission:post.feature')->only('toggle_feature');
  }
  public function admin(){
  
    $user = DB::table('users')->count();
    $post = DB::table('posts')->count();
    $likes = DB::table('likes')->count();
    $hashtags = DB::table('hashtags')->count();
    $categories = DB::table('categories')->count();
    $comments = DB::table('comments')->count();
    $blocked = DB::table('users')->where('is_blocked',1)->count();
    $reports = DB::table('post_reports')->count();
    $year = request('year', date('Y'));

    $data = $this->stats->getStats($year);             
    return view('admin.adminpanel',compact(['user','post','likes','hashtags','categories','comments','blocked','reports','data']));
  }

  public function users(Request $request)
  {
    $blocked = (bool) $request->get('blocked', false);

  $users = User::with(['roles','roles.permissions','userPermissions']) 
               ->select('id','name','username','email','avatar','created_at','phone','age','is_blocked','email_verified_at')
               ->latest()
               ->search($request->only('search'))
               ->when($blocked, fn($q) => $q->where('is_blocked', 1))
               ->paginate(6)
               ->withQueryString();
    $roles = Role::all();
    return view('admin.users',[
      'users'=>$users,
      'filter'=>$request->only(['search','blocked']),
      'permissions' => Permission::all(),
      'roles'=>$roles
    ]);
  }
public function createuser(CreateUserRequest $request)
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
public function updateuser(UpdateUserRequest $request, User $user)
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
  public function posts(Request $request)
  {
    $sort = $request->get('sort', 'latest'); 
    $choose = $sort === 'oldest' ? 'ASC' : 'DESC';
    $featured = (bool) $request->get('featured',false);
    $reported = (bool) $request->get('reported',false);
    $posts = Post::with(['user','hashtags'])
          ->search($request->get('search'))
          ->withCount('totalcomments')
          ->when($featured, fn($q) => $q->where('is_featured', 1))
          ->when($reported, fn($q) => $q->where('is_reported', 1))
          ->orderBy('created_at', $choose)
          ->paginate(6)
          ->withQuerystring();


    return view('admin.posts',[
      'posts'=>$posts,
      'filter'=>$request->only('search','sort','featured')
    ]);
  }
public function featuredpage(){
  return view('admin.featuredposts',[
    'allhashtags' => Hashtag::pluck('name'),
    'categories' => Category::select('id','name')->get()
  ]);
}

  public function create_feature(CreatePostRequest $request,PostService $service){
  
 $dto = CreatePostDTO::fromAppRequest($request);
 $service->create($dto);  
toastr()->success('post feature created',['timeOut'=>1000]);
return to_route('admin.posts');
  }
  public function destroy(User $user){
  
    
    $this->authorize('delete',$user);
    $user->delete();
    toastr()->success('user deleted',['timeOut'=>1000]);
    return back();
  }
  public function toggle_block(User $user){
    $this->authorize('block',$user);
    $user->update(['is_blocked' => !$user->is_blocked]);
    if($user->is_blocked){
    toastr()->success('user blocked success',['timeOut'=>1000]);
  }else{
      toastr()->success('user unblocked success',['timeOut'=>1000]);
  }
      return redirect()->back();
  }

 public function toggle_feature(Post $post)
 {
  $this->authorize('make_feature',$post);
  $post->update(['is_featured'=>!$post->is_featured]);
  if($post->is_featured){
    toastr()->success('post featured success',['timeOut'=>1000]);
  }else{
      toastr()->success('post unfeatured success',['timeOut'=>1000]);
  }
  return redirect()->back();
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
