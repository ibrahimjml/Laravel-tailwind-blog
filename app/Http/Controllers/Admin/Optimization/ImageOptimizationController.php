<?php

namespace App\Http\Controllers\Admin\Optimization;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\ImageoptimizationRequest;
use App\Models\Setting;

class ImageOptimizationController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.optimization.image_optimization', compact('settings'));
    }

    public function imageOptimizationUpdate(ImageoptimizationRequest $request)
    {
      foreach ($request->validated() as $key => $value) {
        Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value ?? '',
            ]
        );
    }
     toastr()->success('image settings updated successfuly',['timeOut' => 1000]);
     return redirect()->back();
    }
}
