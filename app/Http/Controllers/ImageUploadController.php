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
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $image = $request->file('image');
        $filenameBase = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = time();
        $extension = $image->getClientOriginalExtension();
        $path = public_path('images/');

        //   v3 intervention syntax compatible with laravel 12
        $manager = new ImageManager(new GdDriver());

        $img = $manager->read($image->getRealPath());

        $img->scale(width: 400)->save($path . "{$filenameBase}-400.{$extension}");
        $img->scale(width: 800)->save($path . "{$filenameBase}-800.{$extension}");
        $img->scale(width: 1600)->save($path . "{$filenameBase}-1600.{$extension}");

        return response()->json([
            'message' => 'Image uploaded and resized!',
        ]);
    }
}

