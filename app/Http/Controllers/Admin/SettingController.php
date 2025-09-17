<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function settings(User $user)
    {
        $user = auth()->user();
        $user->loadCount(['followers','followings']);
        return view("admin.setting",[
          'user'=>$user,
          'postcount' => $user->post()->count(),
          'likescount' => $user->post()->withCount('likes')->get()->sum('likes_count'),
          'commentscount' => $user->post()->withCount('comments')->get()->sum('comments_count')
        ]);
    }

  public function update_settings(Request $request, User $user)
{
    $fields = $request->validate([
        "name" => ["required", "min:5", "max:50", "alpha", Rule::unique(User::class)->ignore($user->id)],
        "email" => ["required", "email", "min:5", "max:50", Rule::unique(User::class)->ignore($user->id)],
        "phone" => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique(User::class)->ignore($user->id)],
        "username" => ["required", "min:5", "max:15", "alpha_num", Rule::unique(User::class)->ignore($user->id)],
    ], [
        'phone.regex' => 'The phone number must include a valid country code.',
    ]);

    foreach ($fields as $key => $value) {
        $fields[$key] = trim(strip_tags($value));
    }

    $user->fill($fields);

    if (!$user->isDirty()) {
        toastr()->info('No changes detected.', ['timeOut' => 1000]);
        return back();
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    toastr()->success('Profile updated successfully.', ['timeOut' => 1000]);
    return redirect()->back();
   }
  
   public function update_pass(Request $request,User $user)
   {
      $request->validate([
      "current_password"=>["required"],
      "password" => ["alpha_num", "min:8", "max:32", "confirmed"]
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
      toastr()->error('Current password is incorrect',['timeOut'=>1000]);
      return back();
  }
    $user->password = bcrypt($request->password);
    $user->save();
    toastr()->success('password updated',['timeOut'=>1000]);
    return redirect()->back();
   }

   public function update_aboutme(Request $request,User $user)
   {
       $request->validate([
         'about'=>'nullable|string|'
        ]);
   $aboutme = strip_tags($request->about);
   $user->aboutme = $aboutme !== '' ? $aboutme : null;
   if(!$user->isDirty('aboutme')){
      toastr()->info('No changes detected.', ['timeOut' => 1000]);
      return back();
   }
   $user->save();
   toastr()->success('aboutme updated',['timeOut'=>1000]);
   return redirect()->back();
   }
}

