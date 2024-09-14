<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
      }

    
      return view('blog',['posts'=>$posts,'sorts'=>$sortoption]);
      
      
    }

    public function createpage(){
      return view('create');
    }

  
        public function create(Request $request){
          $fields=$request->validate([
            'title'=>'required',
            'description'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        $fields['title'] = strip_tags($fields['title']);
        $fields['description'] = strip_tags($fields['description']);

        $slug = Str::slug($fields['title'], '-');
        
        
        $newimage= uniqid().'-'.$slug.'-'.$fields['image']->extension();
        $fields['image']->move(public_path('images'),$newimage);
        
        
        Post::create([
          'title'=>$request->input('title'),
          'description'=>$request->input('description'),
          'slug'=>$slug,
          'image_path'=>$newimage,
          'user_id'=>auth()->user()->id
        ]);
        
        return redirect('/blog')->with('success','posted successfuly');
        }

         public function delete($slug){

           $post = Post::where('slug',$slug)->firstOrFail();

           if (auth()->user()->id !== $post->user_id) {
             return response()->json(['error' => 'Unauthorized'], 403);
         }
         
        $this->authorize('delete',$post);
        $post->delete();
         
        return redirect('/blog')->with('success','Post deleted successfully');
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



