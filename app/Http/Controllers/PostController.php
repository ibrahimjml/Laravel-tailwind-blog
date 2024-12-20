<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use App\Mail\postlike;
use App\Models\Hashtag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PostController extends Controller 
{
  public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }

    public function blog(Request $request){
    
      $sortoption = $request->get('sort','latest');
      $posts = Post::query()
      ->with(['user:id,username,avatar', 'hashtags:id,name'])
      ->withCount(['likes', 'comments']);
      
      switch($sortoption){
        case 'latest';
        $posts->latest();
        break;

        case 'oldest';
        $posts->oldest();
        break;

        case 'mostliked':
          $posts->withCount('likes')->orderBy('likes_count', 'desc');
          break;
 
          case 'hashtagtrend':

    $trendingHashtag = Hashtag::withCount('posts')
    ->orderBy('posts_count', 'desc')
    ->first();

if ($trendingHashtag) {
    
    $posts->whereHas('hashtags', function ($query) use ($trendingHashtag) {
        $query->where('hashtags.id', $trendingHashtag->id);
    });
} else {
  
    $posts->whereRaw('0 = 1');
}
break;

            default:
            $posts->latest();
            break;
          }
            $posts = $posts->paginate(5)->appends(['sort' => $sortoption]);

          
            return view('blog', [
                'posts' => $posts,
                'sorts' => $sortoption,
            ]);
      
    }

    public function createpage(){
      return view('create');
    }

  
        public function create(Request $request){
          $fields=$request->validate([
            'title'=>'required|string|regex:/^[A-Za-z0-9\s]+$/|max:50',
            'description'=>'required|string',
            'image'=>'required|mimes:jpg,png,jpeg|max:5000000',
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
          'user_id'=>auth()->user()->id
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

        return redirect('/blog')->with('success','posted successfuly');
        }
        
         public function delete($slug){
        
           $post = Post::where('slug',$slug)->firstOrFail();
           $this->authorize('delete',$post);
           $post->delete();
         if(auth()->user()->is_admin){
          return redirect('/admin-panel')->with('success','Post deleted successfully');
         }else{

           return redirect('/blog')->with('success','Post deleted successfully');
         }
    }
public function editpost($slug){
  $post = Post::where('slug',$slug)->firstOrFail();
  $hashtags = $post->hashtags()->pluck('name')->implode(', ');
  $this->authorize('view',$post);
  return view('updatepost',compact('post','hashtags'));
}

public function update($slug,Request $request){
  $post = Post::where('slug',$slug)->firstOrFail();

  $fields=$request->validate([
    'title'=>'nullable|string|regex:/^[A-Za-z0-9\s]+$/|max:50',
    'description'=>'required|string',
    'hashtag' => 'nullable|string',
],
['title.regex'=>'The title accept only letters,numbers and spaces',
]);

$fields['title'] = $fields['title'];
$fields['description'] = $fields['description'];
$fields['hashtag'] = $fields['hashtag'];

$post->title = $fields['title'];
$post->description = $fields['description'];

if (!empty($fields['hashtag'])) {
  $hashtagNames = explode(',', $fields['hashtag']);
  $hashtagIds = [];
  
  foreach ($hashtagNames as $name) {
      $hashtag = Hashtag::firstOrCreate(['name' => strip_tags(trim($name))]);
      $hashtagIds[] = $hashtag->id;
  }


  $post->hashtags()->sync($hashtagIds);
}else{
  $post->hashtags()->detach();
}

$this->authorize('update',$post);
$post->save();
return redirect('/blog')->with('success','Post updated successfully');
}

    public function like(Post $post){

      if($post->is_liked()){
       $post->likes()->where('user_id',auth()->user()->id)->delete();
       return response()->json(['liked'=>false]);
       }
       $post->likes()->create(['user_id'=> auth()->user()->id]);
      
      Mail::to($post->user)->queue(new postlike($post->user,auth()->user(),$post));
      return response()->json(['liked'=>true]);
    

    }

    public function save(Request $request){
      $fields =$request->validate([
           'post_id'=>'required|int'
      ]);
      $postId = $fields['post_id'];
      $savedposts = session('saved-to',[]);
      if(in_array($postId,$savedposts)){
        $savedposts = array_diff($savedposts,[$postId]);
        session(['saved-to'=>$savedposts]);
        return response()->json(['status'=>'removed']);
      }else{
        $savedposts[]=$postId;
        session(['saved-to'=>$savedposts]);
        return response()->json(['status'=>'added']);
      }
    }

    public function getsavedposts(){
    
      $getposts =session('saved-to',[]);
      $posts = Post::whereIn('id',$getposts)
      ->withCount(['likes','comments'])
      ->with(['user','hashtags'])
      ->paginate(5);
      return view('getsavedposts',['posts'=>$posts]);
    }


  
    }



