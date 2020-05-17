<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Repositories\Contracts\CommentContract;
use App\Repositories\Contracts\DesignContract;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comments;
    protected $designs;

    public function __construct(CommentContract $comments, DesignContract $designs)
    {
        $this->comments = $comments;
        $this->designs = $designs;
    }

    public function store(Request $request, $designId)
    {
        $this->validate($request, [
            'body' => ['required']
            ]);

        $comment = $this->designs->addComment($designId, [
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        return new CommentResource($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = $this->comments->find($id);
        $this->authorize('update', $comment);

        $this->validate($request, [
            'body' => ['required']
        ]);

       $comment = $this->comments->update($id, [
            'body' => $request->body
            ]);

        return new CommentResource($comment);
    }

    public function destroy($id)
    {
        $comment = $this->comments->find($id);
        $this->authorize('delete', $comment);

        $isDeleted = $this->comments->delete($id);

        if ($isDeleted) {
            return response()->json(['message' => 'Comment Deleted'], 200);
        }

        return response()->json(['message' => 'Bad Request'], 400);
    }
}
