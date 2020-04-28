<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use App\Repositories\Contracts\DesignContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesignController extends Controller
{
    protected $designs;

    public function __construct(DesignContract $designs)
    {
        $this->designs = $designs;
    }

    public function index()
    {
        $designs = $this->designs->all();
        return DesignResource::collection($designs);
    }

    public function update(Request $request, Design $design)
    {
        $this->validate($request, [
            'title' => ['required', 'unique:designs,title,' . $design->id],
            'description' => ['required', 'string', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);

        $this->authorize('update', $design);

        if($design->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'You cannot update other users\'s designs'], 422);
        }

        $design->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => ! $design->upload_successful ? false : $request->is_live
        ]);

        // apply the tags
        $design->retag($request->tags);

        return new DesignResource($design);
    }

    public function destroy(Design $design)
    {
        $this->authorize('delete', $design);
        foreach (['thumbnail', 'original', 'large'] as $size){
            // check if the file exists
            if(Storage::disk($design->disk)->exists('uploads/designs/'.$size.'/'.$design->image)){
                Storage::disk($design->disk)->delete('uploads/designs/'.$size.'/'.$design->image);
            }
        }
        $isSucceeded = $design->delete();
        if($isSucceeded){
            return response()->json(['message' => 'Design Deleted'], 200);
        }

        return response()->json(['message' => 'Bad Request'], 400);
    }
}
