<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileUploadController extends Controller
{
    public function storeUploadImage(Request $request)
    {
        $image = $request->file('profile_image');
        if ($image) {
            $uploadedFileUrl = Cloudinary::upload($image->getRealPath())->getSecurePath();        
        }
    }
}