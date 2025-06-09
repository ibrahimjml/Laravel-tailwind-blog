<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageUploadTrait;
class EditProfileController extends Controller
{
  use ImageUploadTrait;
      public function __construct()
  {
    $this->middleware(['auth','verified','password.confirm',CheckIfBlocked::class]);
  }
    public function editavatarpage(User $user)
  {
    $this->authorize('update', $user);
    return view('edit-avatar', compact('user'));
  }

  public function editavatar(Request $request, User $user)
  {
      $this->authorize('update', $user);
     $request->validate([
      'avatar' => 'required|image|mimes:png,jpeg,jpg|max:5048'
    ]);
      if ($user->avatar !== 'default.jpg' && Storage::disk('public')->exists("avatars/{$user->avatar}")) {
        Storage::disk('public')->delete("avatars/{$user->avatar}");
    }
    $newavatar = $this->uploadAvatarImage($request->file('avatar'),$user->name);

    $user->avatar = $newavatar;
    $user->save();
    toastr()->success('Avatar updated successfully',['timeOut'=>1000]);
    return redirect()->route('profile',  $user->username);
    
  }
  public function destroyavatar(User $user){
    $this->authorize('delete',$user);
     if ($user->avatar !== 'default.jpg' && Storage::disk('public')->exists("avatars/{$user->avatar}")) {
        Storage::disk('public')->delete("avatars/{$user->avatar}");
    }
    $user->avatar="default.jpg";
    $user->save();
    toastr()->success('Avatar deleted',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editcoverpage(User $user)
  {
     $this->authorize('update', $user);
    return view('edit-cover', compact('user'));
  }
    public function editcover(User $user,Request $request)
  {
    $this->authorize('update', $user);
    $request->validate([
      'cover' => 'required|image|mimes:png,jpeg,jpg|max:5048'
    ]);
    
     if ($user->cover_photo !=='sunset.jpg' && Storage::disk('public')->exists("covers/{$user->cover_photo}")) {
        Storage::disk('public')->delete("covers/{$user->cover_photo}");
    }
    $newcover = $this->uploadCoverImage($request->file('cover'),$user->name);

    $user->cover_photo = $newcover;
    $user->save();
    toastr()->success('Cover updated successfully',['timeOut'=>1000]);
    return redirect()->route('profile',  $user->username);
  }
    public function destroycover(User $user)
  {
     $this->authorize('delete', $user);
     if ($user->cover_photo !== 'sunset.jpg' && Storage::disk('public')->exists("covers/{$user->cover_photo}")) {
        Storage::disk('public')->delete("covers/{$user->cover_photo}");
    }
    $user->cover_photo = 'sunset.jpg';
    $user->save();
      toastr()->success('Cover deleted',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }
}
