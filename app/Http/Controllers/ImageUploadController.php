<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function showForm()
    {
        return view('image-upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // Max 2MB
        ]);

        $image = $request->file('image');
        $path = $image->store('uploads', 'public');

        return back()->with('success', 'Image uploaded successfully')->with('path', $path);
    }
}
