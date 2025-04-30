<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TinyMCEController extends Controller
{
  public function uploadImage(Request $request)
  {
    try {
      $request->validate([
          'tiny-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', 
      ]);
  } catch (\Exception $e) {
      return response()->json([
          'error' => 'Image is too large. Max size is 5MB.',
      ], 422);
  }

      if ($request->hasFile('tiny-image')) {
          $file = $request->file('tiny-image');
          $filename = 'TinyMCE'.'.'.Str::random(15) . '.' . $file->getClientOriginalExtension();
          
          $path = $file->storeAs('images', $filename, 'public');
          
          return response()->json([
            'location' => '/storage/' . $path  
        ]);
      }

      return response()->json(['error' => 'Upload failed'], 500);
  }

  public function deleteImage(Request $request)
{
    $src = $request->input('image');

    if (!$src) return response()->json(['message' => 'No image provided'], 400);

    $path = parse_url($src, PHP_URL_PATH); 
    $storagePath = str_replace('/storage/', '', $path); 

    if (Storage::disk('public')->exists($storagePath)) {
        Storage::disk('public')->delete($storagePath);
    
        return response()->json(['message' => 'Image deleted']);
    }

    return response()->json(['message' => 'Image not found'], 404);
}
}
