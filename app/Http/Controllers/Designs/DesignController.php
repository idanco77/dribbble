<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use App\Repositories\Contracts\DesignContract;
use App\Repositories\Criteria\{EagerLoad, ForUser, IsLive, LatestFirst};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class  DesignController extends Controller
{
    protected $designs;

    public function __construct(DesignContract $designs)
    {
        $this->designs = $designs;
    }

    public function index()
    {
        $designs = $this->designs->withCriteria([
            new EagerLoad(['user', 'comments'])
        ])->all();
        return DesignResource::collection($designs);
    }

    public function find($id)
    {
        $design = $this->designs->find($id);
        return new DesignResource($design);
    }

    public function update(Request $request, $id)
    {
        $design = $this->designs->find($id);
        $this->authorize('update', $design);
        $this->validate($request, [
            'title' => ['required', 'unique:designs,title,' . $id],
            'description' => ['required', 'string', 'min:20', 'max:140'],
            'tags' => ['required'],
            'team' => ['required_if:assign_to_team,1']
        ]);


        if ($design->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'You cannot update other users\'s designs'], 422);
        }

        $design = $this->designs->update($design->id, [
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => !$design->upload_successful ? false : $request->is_live,
            'team_id' => $request->team ?? null
        ]);

        // apply the tags
        $this->designs->applyTags($id, $request->tags);

        return new DesignResource($design);
    }

    public function destroy($id)
    {
        $design = $this->designs->find($id);
        $this->authorize('delete', $design);
        foreach (['thumbnail', 'original', 'large'] as $size) {
            // check if the file exists
            if (Storage::disk($design->disk)->exists('uploads/designs/' . $size . '/' . $design->image)) {
                Storage::disk($design->disk)->delete('uploads/designs/' . $size . '/' . $design->image);
            }
        }
        $isSucceeded = $this->designs->delete($id);
        if ($isSucceeded) {
            return response()->json(['message' => 'Design Deleted'], 200);
        }

        return response()->json(['message' => 'Bad Request'], 400);
    }


    public function like($id)
    {
        $this->designs->like($id);
        return response()->json(['message' => 'successful'], 200);
    }

    public function checkIfUserHasLiked($designId)
    {
        $isLiked = $this->designs->isLikedByUser($designId);
        return response()->json(['liked' => $isLiked], 200);
    }
}
