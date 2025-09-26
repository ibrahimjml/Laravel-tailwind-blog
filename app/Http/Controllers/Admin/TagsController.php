<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TagStatus;
use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TagsController extends Controller
{
      public  function __construct() {
    
    $this->middleware('permission:tag.view')->only('hashtagpage');
    $this->middleware('permission:tag.create')->only('create_tag');
    $this->middleware('permission:tag.update')->only('edit_tag');
    $this->middleware('permission:tag.delete')->only('delete_tag');
    $this->middleware('permission:tag.feature')->only('toggle_feature_tag');
  }
    public function create_tag(Request $request){
  $fields = $request->validate([
  'name' =>'required|string',
  'status' => ['required', new Enum(TagStatus::class)]
  ]);
 $hashtag = Hashtag::create($fields);
  return response()->json([
    'added'=>true,
    'hashtag' => $hashtag->name
  ]);
}

  public function hashtagpage(Request $request){
    $sort = $request->get('sort','all');
    $hashtags = Hashtag::query()
              ->status($sort)
              ->paginate(6);
    return view('admin.hashtags.hashtags',[
      'hashtags' => $hashtags
    ]);
  }

public function edit_tag(Hashtag $hashtag, Request $request){
  $fields = $request->validate([
    'name' =>'nullable|string',
    'status' => ['required', new Enum(TagStatus::class)]
    ]);
    $hashtag->update([
              'name' => $fields['name'],
              'status' => $fields['status']
            ]);
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
