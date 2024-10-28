<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function blog(Request $request){
    
      $sortoption = $request->get('sort','latest');
      if($sortoption == 'latest'){
        $posts = Post::orderBy('created_at','desc')->paginate(5);
      }
      elseif($sortoption == 'oldest'){
        $posts = Post::orderBy('created_at','asc')->paginate(5);
      }elseif ($sortoption == 'mostliked') {
        
        $posts = Post::withCount('likes')->orderBy('likes_count', 'desc')->paginate(5);
    }
      $posts->appends(['sort' => $sortoption]);
    
      return view('blog',['posts'=>$posts,'sorts'=>$sortoption]);
      
      
    }

    public function createpage(){
      return view('create');
    }

  
        public function create(Request $request){
          $fields=$request->validate([
            'title'=>'required|string|regex:/^[A-Za-z0-9\s]+$/|max:50',
            'description'=>'required|string',
            'image'=>'required|mimes:jpg,png,jpeg|max:5000000'
        ],
        ['title.regex'=>'The title accept only letters,numbers and spaces',
      ]);

        $fields['title'] = htmlspecialchars(strip_tags($fields['title']));
        $fields['description'] = $fields['description'];

        $slug = Str::slug($fields['title']);
        $uniqueslug=$this->generateuniqueslug($slug);
        
        $newimage= uniqid().'-'.$slug.'.'.$fields['image']->extension();
        $fields['image']->move(public_path('images'),$newimage);
      
        Post::create([
          'title'=>$request->input('title'),
          'description'=>$request->input('description'),
          'slug'=>$uniqueslug,
          'image_path'=>$newimage,
          'user_id'=>auth()->user()->id
        ]);
        
        return redirect('/blog')->with('success','posted successfuly');
        }
          //generate unique slug
        private function generateuniqueslug($slug){
          $originslug =$slug;
          $count =1;
          while(Post::where('slug',$slug)->exists()){
            $slug = $originslug.'-'.$count;
            $count++;
          }
          return $slug;
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
  $this->authorize('view',$post);
  return view('updatepost',compact('post'));
}

public function update($slug,Request $request){
  $fields=$request->validate([
    'title'=>'nullable|string|regex:/^[A-Za-z0-9\s]+$/|max:50',
    'description'=>'required|string'
],
['title.regex'=>'The title accept only letters,numbers and spaces',
]);

$fields['title'] =htmlspecialchars(strip_tags($fields['title'])) ;
$fields['description'] =$fields['description'] ;

$post = Post::where('slug',$slug)->firstOrFail();

$slug = Str::slug($fields['title']);


$post->title = $fields['title'];
$post->description = $fields['description'];
$post->slug=$slug;

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
      $posts = Post::whereIn('id',$getposts)->paginate(5);
      return view('getsavedposts',['posts'=>$posts]);
    }


  
    }



