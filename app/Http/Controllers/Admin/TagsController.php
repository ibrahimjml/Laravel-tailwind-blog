<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
      public  function __construct() {
    
    $this->middleware('permission:tag.view')->only('hashtagpage');
    $this->middleware('permission:tag.create')->only('create_tag');
    $this->middleware('permission:tag.update')->only('edit_tag');
    $this->middleware('permission:tag.delete')->only('delete_tag');
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
    'name' =>'nullable|string'
    ]);
    $hashtag->update(['name' => $fields['name']]);
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

  public function toggle_feature_tag(Hashtag $hashtag)
  {
      $hashtag->update(['is_featured'=>!$hashtag->is_featured]);
      if($hashtag->is_featured){
       toastr()->success('hashtag featured success',['timeOut'=>1000]);
      }else{
      toastr()->success('hashtag unfeatured success',['timeOut'=>1000]);
      }
      return redirect()->back();
  }
}
