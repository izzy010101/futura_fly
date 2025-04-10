<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $image = $request->file('image');
        $filenameBase = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $path = public_path('images/');

        $manager = new ImageManager(new GdDriver());
        $original = $manager->read($image->getRealPath());

        $sizes = [400, 800, 1600];

        foreach ($sizes as $width) {
            $clone = clone $original;

            // Resize while maintaining aspect ratio
            $clone->scale(
                width: $width // height = null by default, so aspect ratio is preserved
            )->save("{$path}{$filenameBase}-{$width}.{$extension}", quality: 90);
        }

        return response()->json([
            'message' => 'Image uploaded and resized!',
        ]);
    }
}
