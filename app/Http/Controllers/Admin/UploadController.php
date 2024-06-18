<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageupload(Request $request){
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,webp,gif'
        ]);
        $ext = $request->file->extension();
        $imageName = time().'.'.$ext;
        $request->file->move(public_path('assets/media/images'), $imageName);
        return [
            'location' => asset('assets/media/images/'.$imageName)
        ];
    }
}
