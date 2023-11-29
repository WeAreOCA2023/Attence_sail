<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function storeUploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|max:2048',
        ], [
            'profile_image.required' => '画像を選択してください。',
            'profile_image.image' => '画像ファイルを選択してください。',
            'profile_image.max' => '2MB以下の画像を選択してください。',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $image = $request->file('profile_image');
        if ($image) {
            $uploadedFileUrl = Cloudinary::upload($image->getRealPath(),  [
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill', // 画像が指定したサイズにピッタリと収まるようにトリミング
                    'gravity' => 'face', // 顔を中心にトリミング
                    'radius' => 'max', // 角を丸める
                ]
            ])->getSecurePath();       
            $user = User::where('user_id', Auth::user()->id)->first();
            $user->profile_image = $uploadedFileUrl;
            $user->save();
            return redirect()->back()->with('success', '画像をアップロードしました。');
        }
    }
}