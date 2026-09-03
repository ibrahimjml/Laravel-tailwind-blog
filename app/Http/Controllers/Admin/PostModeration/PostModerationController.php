<?php

namespace App\Http\Controllers\Admin\PostModeration;

use App\Http\Controllers\Controller;
use App\Models\PostModeration;
use Illuminate\Http\Request;

class PostModerationController extends Controller
{
    public function moderationPage()
    {
       
        return view('admin.moderation.post-moderation', [
            'rules' => PostModeration::rules(),
        ]);
    }

    public function updateRules(Request $request)
    {
        $fields = $request->validate([
            'enable_post_submission' => ['required', 'boolean'],
            'enable_auto_approve' => ['required', 'boolean'],
        ]);

        PostModeration::rules()->update($fields);

        toastr()->success('Post moderation rules updated', ['timeOut' => 1000]);

        return back();
    }
}
