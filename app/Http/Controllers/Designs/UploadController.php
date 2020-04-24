<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Jobs\UploadImage;
use App\Models\Design;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // validate the request
        $this->validate($request, [
            'image' => ['required', 'mimes:jpeg,png,gif,bmp,png', 'max:2048']
        ]);

        // get the image from the request
        $image = $request->file('image');
        $imagePath = $image->getPathName();

        // get the original file name and replace any spaces with _
        // Business Cards.png = timestamp()_business_cards.png
        $fileName = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        // move the image to the temporary location (tmp)
        $tmp = $image->storeAs('uploads/original', $fileName, 'tmp');

        // create the db record for the design
        $design = auth()->user()->designs()->create([
            'image' => $fileName,
            'disk' => config('site.upload_disk'),
        ]);

        // dispatch a job to handle the image manipulation
        $this->dispatch(new UploadImage($design));

        return response()->json([$design, 200]);
    }
}
