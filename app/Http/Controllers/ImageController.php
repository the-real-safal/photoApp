<?php
// ImageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function showImages(Request $request)
    {
        // Retrieve the uploaded files from the request
        $uploadedFiles = $request->input('uploadedFiles', []);

        return view('dashboard')->with('uploadedFiles', $uploadedFiles);
    }
}
