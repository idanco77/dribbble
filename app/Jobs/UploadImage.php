<?php

namespace App\Jobs;

use App\Models\Design;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Storage;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $design;

    public function __construct(Design $design)
    {
        $this->design = $design;
    }

    public function handle()
    {
        $disk = $this->design->disk;
        $fileName = $this->design->image;
        $originalFile = storage_path() . '/uploads/original/' . $fileName;

        // we put it in a try catch so it shouldn't crash the application if not succeeded
        try {
            // create the Large image and save to tmp disk
            Image::make($originalFile)
            ->fit(800, 600, function($constraint){
                $constraint->aspectRatio();
            })
            ->save($large = storage_path('uploads/large/' . $fileName));

            // create the thumbnail image and save to tmp disk
            Image::make($originalFile)
                ->fit(250, 200, function($constraint){
                    $constraint->aspectRatio();
                })
                ->save($thumbnail = storage_path('uploads/thumbnail/' . $fileName));

            // store images to permanent disk
            // original image
            if(Storage::disk($disk)
                ->put('uploads/designs/original/' . $fileName, fopen($originalFile, 'r+'))){
                File::delete($originalFile);
            }

            // large image
            if(Storage::disk($disk)
                ->put('uploads/designs/large/' . $fileName, fopen($large, 'r+'))){
                File::delete($large);
            }

            // thumbnail image
            if(Storage::disk($disk)
                ->put('uploads/designs/thumbnail/' . $fileName, fopen($thumbnail, 'r+'))){
                File::delete($thumbnail);
            }

            // update the db record with success flag
            $this->design->update([
                'upload_successful' => true
            ]);

        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        }

    }
}
