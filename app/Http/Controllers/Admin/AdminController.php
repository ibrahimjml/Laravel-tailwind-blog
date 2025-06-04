<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePostRequest;
use App\Models\Hashtag;
use App\Models\Permission;
use App\Models\Post;
use App\Models\User;
use App\Services\PostHashtagsService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function __construct()
  {

    $this->middleware('permission:user.view')->only('users');
    $this->middleware('permission:user.create')->only('createuser');
    $this->middleware('permission:user.edit')->only('updateuser');
    $this->middleware('permission:user.block')->only(['block','unblock']);
    $this->middleware('permission:user.role')->only('role');
    $this->middleware('permission:user.delete')->only('destroy');
  }
  public function admin(){
  
    $user = DB::table('users')->count();
    $post = DB::table('posts')->count();
    $likes = DB::table('likes')->count();
    $hashtags = DB::table('hashtags')->count();
    $comments = DB::table('comments')->count();
    $blocked = DB::table('users')->where('is_blocked',1)->count();
    $year = request('year', date('Y'));

    $registeredusers = User::select(DB::raw('COUNT(*) as count'), DB::raw('MONTHNAME(created_at) as month'))
                            ->whereYear('created_at', $year)
                            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
                            ->pluck('count', 'month')
                            ->toArray();
    $numberofposts = Post::select(DB::raw('COUNT(*) as count'), DB::raw('MONTHNAME(created_at) as month'))
                            ->whereYear('created_at', $year)
                            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
                            ->pluck('count', 'month')
                            ->toArray();                    
    return view('admin.adminpanel',compact(['user','post','likes','hashtags','comments','blocked','registeredusers','numberofposts']));
  }

  public function users(Request $request)
  {
    $blocked = $request->has('blocked') ? 1 : null;

  $users = User::with(['roles','roles.permissions','userPermissions']) 
               ->select('id','name','username','email','avatar','created_at','phone','age','is_blocked','email_verified_at')
               ->latest()
               ->search($request->only('search'))
               ->when($blocked, function($q){
                   $q->where('is_blocked', 1);
               })
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

    $query = Post::with(['user','hashtags'])
          ->search($request->only('search'))
          ->withCount('totalcomments');
    if($request->has('featured')){
     $query->featured();
    };

    $posts = $query
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
    'allhashtags' => Hashtag::pluck('name')
  ]);
}

  public function features(CreatePostRequest $request,PostHashtagsService $tagsservice){
  
    $isFeatured = $request->has('featured') ? true : false;
    $fields = $request->validated();

  $fields['title'] = htmlspecialchars(strip_tags($fields['title']));
    $allow_comments = $request->has('enabled') ? 1 : 0;
    $slug = Str::slug($fields['title']);


    $newimage = uniqid() . '-' . $slug . '.' . $fields['image']->extension();
    $image = Image::read($request->file('image'))
    ->resize(1300, 600)
    ->encode();
    Storage::disk('public')->put("uploads/{$newimage}", $image);

  $post = Post::create([
      'title' => $request->input('title'),
      'description' => $request->input('description'),
      'slug' => $slug,
      'image_path' => $newimage,
      'allow_comments' => $allow_comments,
      'user_id' => auth()->user()->id,
      'is_featured'=>$isFeatured
  ]);

if (request()->filled('hashtag')) {
      $tagsservice->attachhashtags($post,$request->input('hashtag'));
  }
toastr()->success('post feature created',['timeOut'=>1000]);
return back();
  }
  public function destroy(User $user){
  
    
    $this->authorize('delete',$user);
    $user->delete();
    toastr()->success('user deleted',['timeOut'=>1000]);
    return back();
  }
  public function block(User $user){
    $this->authorize('block',$user);
    $user->is_blocked = true;
    $user->save();
    toastr()->success('user blocked',['timeOut'=>1000]);
    return back();
  }
  public function unblock(User $user){
    $this->authorize('block',$user);
    $user->is_blocked = false;
    $user->save();
    toastr()->success('user unblocked successfuly',['timeOut'=>1000]);
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
