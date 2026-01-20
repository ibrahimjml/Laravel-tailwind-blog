<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\AdminNotificationSetting;
use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
        public function __construct()
{
    $this->middleware('permission:notifications.view')->only('notification_view');
    $this->middleware('permission:notifications.update')->only('toggle_notification');
    $this->middleware('permission:smtp.view')->only('smtp');
    $this->middleware('permission:smtp.update')->only(['smtp_config','testmail']);

}
    public function settings(User $user)
    {
        $user = auth()->user();
        $user->loadCount(['followers','followings']);
        return view("admin.settings.setting",[
          'user'=>$user,
          'postcount' => $user->post()->count(),
          'likescount' => $user->post()->withCount('likes')->get()->sum('likes_count'),
          'commentscount' => $user->post()->withCount('comments')->get()->sum('comments_count')
        ]);
    }

  public function updateSettings(Request $request, User $user)
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
  
   public function updatePassword(Request $request,User $user)
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

   public function updateAboutme(Request $request,User $user)
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
   public function smtp()
   {
    return view('admin.settings.smtp-settings',[
      'smtp'=>SmtpSetting::first()
    ]);
   }
   public function smtp_config(Request $request)
   {
      $fields = $request->validate([
        'mail_transport' => ['sometimes'],
        'mail_host' => ['sometimes'],
        'mail_port' => ['sometimes'],
        'mail_username' => ['sometimes'],
        'mail_password' => ['sometimes'],
        'mail_encryption' => ['sometimes'],
        'mail_from' => ['sometimes'],

      ]);
      $smtp = SmtpSetting::firstOrNew();
      $smtp->fill($fields);
      $smtp->save();
      toastr()->success('smtp fields saved',['timeOut'=>1000]);
      return redirect()->back();
   }
   public function testmail(Request $request)
   {
      $admin = User::where('is_admin',1)->value('email');
      $message = 'this is a test mail';
      Mail::raw($message,function($test) use ($admin){
        $test->to($admin)->subject('Testing mail');
      });
      toastr()->success('mail sent',['timeOut'=>1000]);
      return redirect()->back();
   }
   public function notification_view()
   {
    $setting = AdminNotificationSetting::where('user_id',auth()->id())->pluck('is_enabled','type')->toArray();
    return view('admin.settings.notification-control',[
      'setting' => $setting,
    ]);
   }
   public function toggle_notification(Request $request)
   {
    $request->validate([
        'notifications' => ['nullable', 'array'],
    ]);

    $notifications = $request->input('notifications', []);
    

    foreach (\App\Enums\NotificationType::cases() as $type) {
      $setting = AdminNotificationSetting::where('user_id', auth()->id())->where('type', $type->value)->first();
      $enabled = isset($notifications[$type->value]) ? 1 : 0;
      $setting->update(
        [
                'is_enabled' => $enabled,
            ]
        );
    }

    toastr()->success('Notification settings updated', ['timeOut' => 1000]);
    return redirect()->back();
   }
}

