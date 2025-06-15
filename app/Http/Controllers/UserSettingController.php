<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfBlocked;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    public function __construct()
  {
    $this->middleware(['auth','verified',CheckIfBlocked::class]);
  }
      public function editprofilepage(User $user)
  {

    $this->authorize('view',$user);
  
    return view('edit-profile',['user' => $user]);
  }


  public function editemail(Request $request, User $user)
  {
    $request->validate([
      "email" => ["required", "email", "min:5", "max:50", Rule::unique(User::class)->ignore($user->id)]
    ]);

    $this->authorize('update', $user);
    $newemail = trim(strip_tags($request->email));
      if ($user->email === $newemail) {
        toastr()->info('Email is already up to date.', ['timeOut' => 1000]);
        return redirect()->back();
    }
    $user->email = $newemail;
    $user->email_verified_at = null;
    $user->save();

    toastr()->success('Email updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editname(Request $request, User $user)
  {
    $request->validate([
      "name" => ["required", "min:5", "max:50", "alpha", Rule::unique("users", "name")->ignore($user->id)]
    ]);
    $newname = trim(strip_tags($request->name));
      if ($user->name === $newname) {
        toastr()->info('Name is already up to date.', ['timeOut' => 1000]);
        return redirect()->back();
    }
    $this->authorize('update', $user);
    $user->name = $newname;
    $user->save();
    toastr()->success('name updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editpassword(Request $request, User $user)
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
    $this->authorize('update', $user);
    $user->save();
    toastr()->success('password updated',['timeOut'=>1000]);
    return redirect()->route('profile', $user->username);
  }

  public function editphone(Request $request, User $user)
  {
    $request->validate([
      "phone" => ['required', 'regex:/^\+\d{8,15}$/', Rule::unique(User::class)->ignore($user->id)]
    ],[
      'phone.regex' => 'The phone number must include a valid country code.'
    ]);
    $newPhone = trim(strip_tags($request->phone));
      if ($user->phone === $newPhone) {
        toastr()->info('Phone number is already up to date.', ['timeOut' => 1000]);
        return redirect()->back();
    }
    $this->authorize('update', $user);
    $user->phone = $newPhone;
    $user->save();
    toastr()->success('phone updated',['timeOut'=>1000]);
    return redirect()->route('profile', ['user' => $user->username]);
  }

  public function useraddbio(User $user,Request $request){
   $request->validate([
    'bio'=>'nullable|min:5|string'
   ]);
   $user->bio = strip_tags($request->bio);
   $this->authorize('update',$user);
   $user->save();
   toastr()->success('Bio updated',['timeOut'=>1000]);
   return redirect()->route('profile', ['user' => $user->username]);
  }
  public function social_links(User $user,Request $request)
  {
    $fields = $request->validate([
      'github' => 'nullable|url',
      'linkedin' => 'nullable|url',
      'twitter' => 'nullable|url',
    ]);
      foreach ($fields as $key => $value) {
        $fields[$key] = trim(strip_tags($value));
    }
      $user->fill($fields);
      $user->save();
  
      toastr()->success('link added successfuly',['timeOut'=>1000]);
      return back();
    }
    public function custom_links(User $user,Request $request)
    {
      $fields = $request->validate([
      'social_links' => 'array',
      'social_links.*.platform' => 'nullable|string',
      'social_links.*.url' => 'nullable|url',
    ]);
      foreach ($fields as $key => $value) {
        if(!is_array($value)){
        $fields[$key] = trim(strip_tags($value));
        }
    }

      foreach ($request->social_links ?? [] as $link) {
    $user->socialLinks()->updateOrCreate([
        'platform' => $link['platform'],
        'url' => $link['url'],
    ]);
   }
      toastr()->success('custom link added ',['timeOut'=>1000]);
      return back();
    }
    public function destroy_link(SocialLink $link)
    {
      $this->authorize('deleteSocial',$link);

     $link->delete();

    return response()->json(['message' => 'Deleted']);
   }
    
  public function useraboutme(User $user,Request $request){
   $request->validate([
    'about'=>'nullable|string'
   ]);
   $aboutme = strip_tags($request->about);
   $user->aboutme = $aboutme !== '' ? $aboutme : null;
      if(!$user->isDirty('aboutme')){
      toastr()->info('No changes detected.', ['timeOut' => 1000]);
      return back();
   }
   $this->authorize('update',$user);
   $user->save();
   toastr()->success('aboutme updated',['timeOut'=>1000]);
   return redirect()->route('profile', ['user' => $user->username]);
  }

  public function deleteaccount(Request $request,User $user){
    $request->validate([
      'check_pass'=>"required|alpha_num|min:8|max:32"
    ]);
  
    if (!Hash::check($request->check_pass, $user->password)) {
      toastr()->error('password is incorrect',['timeOut'=>1000]);
      return back();
  }
  $this->authorize('delete',$user);
  $user->delete();
  auth()->logout();
  toastr()->success('Account deleted successfuly',['timeOut'=>1000]);
  return redirect()->route('login');
  }
}
