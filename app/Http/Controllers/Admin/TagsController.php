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
    'name' =>'required|string'
    ]);
    $hashtag->update($fields);
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
}
