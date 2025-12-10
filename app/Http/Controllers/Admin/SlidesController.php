<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Admin\SlideDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Admin\CreateSlideRequest;
use App\Http\Requests\App\Admin\UpdateSlideRequest;
use App\Models\Slide;
use App\Services\Admin\SlidesService;
use App\Traits\ImageUploadTrait;


class SlidesController extends Controller
{
    use ImageUploadTrait;
    public function __construct(private SlidesService $service)
{
    $this->middleware('permission:slide.view')->only('index');
    $this->middleware('permission:slide.create')->only('store');
    $this->middleware('permission:slide.update')->only('update');
    $this->middleware('permission:slide.delete')->only('destroy');
}
    public function index()
    {
        $slides = $this->service->getSlides();
        return view('admin.slides.slides',['slides' => $slides]);
    }

  

      public function store(CreateSlideRequest $request)
    {
        $dto = SlideDTO::fromRequest($request, auth()->id());
        $this->service->create($dto, auth()->id());
  
        return response()->json([
          'created'=>true,
          'message'=>'slide created'
        ],201);
    }


public function update(UpdateSlideRequest $request, string $id)
{      
        $slide = Slide::findOrFail($id);

        $dto = SlideDTO::fromRequest($request, auth()->id());
        $this->service->update($slide,$dto, auth()->id());

    return response()->json([
        'updated' => true,
        'message' => 'Slide updated successfully'
    ], 200);
}

    public function destroy(string $id)
    {
        $slide = Slide::find($id);
        $this->service->deleteSlide($slide);
        
        return response()->json([
          'deleted' => true,
          'message' => 'deleted successfully'
        ],200);
    }
}
