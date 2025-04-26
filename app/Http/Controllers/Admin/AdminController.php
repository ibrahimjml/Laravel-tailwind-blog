<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function admin(){
  
    $user = DB::table('users')->count();
    $post = DB::table('posts')->count();
    $likes = DB::table('likes')->count();
    $hashtags = DB::table('hashtags')->count();
    $comments = DB::table('comments')->count();
    $blocked = DB::table('users')->where('is_blocked',1)->count();
    return view('admin.adminpanel',compact(['user','post','likes','hashtags','comments','blocked']));
  }

  public function users(Request $request)
  {
    $blocked = $request->has('blocked') ? 1 : null;

    $users = User::select('id','name','username','email','avatar','created_at','phone','age','is_blocked','email_verified_at','is_admin')
    ->latest()
    ->search($request->only('search'))
    ->when($blocked,function($q){
      $q->where('is_blocked',1);
    })
    ->paginate(6)
    ->withQuerystring();
    return view('admin.users',['users'=>$users,'filter'=>$request->only(['search','blocked'])]);
  }

  public function posts(Request $request)
  {
    $sort = $request->get('sort', 'latest'); 
    $choose = $sort === 'oldest' ? 'ASC' : 'DESC';

    $query = Post::with(['user','hashtags'])
          ->search($request->only('search'))
          ->withCount(['likes', 'comments']);
          if($request->has('featured')){
           $query->featured();
          };

    $posts = $query
          ->orderBy('created_at', $choose)
          ->paginate(6)
          ->withQuerystring();

    return view('admin.posts',['posts'=>$posts,'filter'=>$request->only('search','sort','featured')]);
  }

public function create_tag(Request $request){
  $fields = $request->validate([
  'name' =>'required|string'
  ]);
 $hashtag = Hashtag::create($fields);
  return response()->json([
    'added'=>true,
    'hashtag' => $hashtag->name
  ]);
}

  public function hashtagpage(){
    return view('admin.hashtags',[
      'hashtags' => Hashtag::paginate(6)
    ]);
  }

public function edit_tag(Hashtag $hashtag, Request $request){
  $fields = $request->validate([
    'name' =>'required|string'
    ]);
    $hashtag->update($fields);
    $hashtag->save();
    return response()->json([
      'edited'=>true,
      'message' => "Hashtag {$hashtag->name} updated",
      'hashtag' => $hashtag->name
    ]);
}

  public function delete_tag(Hashtag $hashtag){
    $name = $hashtag->name;
    $hashtag->delete();
    return response()->json([
      'deleted' => true,
      'message' => "Hashtag {$name} deleted"
  ]);
  }

public function featuredpage(){
  return view('admin.featuredposts',[
    'allhashtags' => Hashtag::pluck('name')
  ]);
}

  public function features(Request $request){
    $isFeatured = $request->has('featured') ? true : false;
    $fields=$request->validate([
      'title'=>'required|string|regex:/^[A-Za-z0-9\s]+$/|max:50',
      'description'=>'required|string',
      'hashtag' => ['nullable', 'string', function ($attribute, $value, $fail) {
        $tags = array_filter(array_map('trim', explode(',', $value)));
        if (count($tags) > 5) {
            $fail('You can only select up to 5 hashtags.');
        }
  }],
      'image'=>'required|mimes:jpg,png,jpeg|max:5000000',
      'featured'=>'nullable|boolean'
  ],
  ['title.regex'=>'The title accept only letters,numbers and spaces',
]);

  $fields['title'] = htmlspecialchars(strip_tags($fields['title']));
  $fields['description'] = $fields['description'];

  $slug = Str::slug($fields['title']);
  
  
  $newimage= uniqid().'-'.$slug.'.'.$fields['image']->extension();
  $fields['image']->move(public_path('images'),$newimage);

  $post = Post::create([
    'title'=>$request->input('title'),
    'description'=>$request->input('description'),
    'slug'=>$slug,
    'image_path'=>$newimage,
    'user_id'=>auth()->user()->id,
    'is_featured'=>$isFeatured
  ]);

$hashtagNames = [];

if ($request->filled('hashtag')) {
  $hashtags = explode(',', $request->input('hashtag'));

  foreach ($hashtags as $hashtag) {
      $hashtag = strip_tags(trim($hashtag)); 

      if ($hashtag) {
          $hashtagModel = Hashtag::firstOrCreate(['name' => $hashtag]);
          $post->hashtags()->attach($hashtagModel->id);
          $hashtagNames[] = $hashtagModel->name;
      }
  }
}
toastr()->success('post feature created',['timeOut'=>1000]);
return back();
  }
  public function destroy(User $user){
  
    
    $this->authorize('modify',$user);
    $user->delete();
    toastr()->success('user deleted',['timeOut'=>1000]);
    return back();
  }
  public function block(User $user){
    $this->authorize('modify',$user);
    $user->is_blocked = true;
    $user->save();
    toastr()->success('user blocked',['timeOut'=>1000]);
    return back();
  }
  public function unblock(User $user){
    $this->authorize('modify',$user);
    $user->is_blocked = false;
    $user->save();
    toastr()->success('user unblocked successfuly',['timeOut'=>1000]);
    return back();
  }

  public function role(Request $request,User $user)
  {
    $this->authorize('modify',$user);
    $fields= $request->validate([
      'role'=>'required|in:user,admin'
    ]);
    $user->is_admin = $fields['role'] === 'admin' ? 1 : 0;
    $user->save();
    toastr()->success('user role {$request->role} updated',['timeOut'=>1000]);
   return back();
  }
}
