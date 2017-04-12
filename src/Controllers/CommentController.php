<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laralum\Blog\Models\Comment;
use Laralum\Blog\Models\Post;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Laralum\Blog\Models\Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $this->authorize('create', Comment::class);

        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('laralum::blog.posts.show', ['post' => $post->id])
            ->with('success', __('laralum_blog::general.comment_added'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request     $request
     * @param \Laralum\Blog\Models\Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->route('laralum::blog.posts.show', ['post' => $comment->post->id])->with('success', __('laralum_blog::general.comment_updated', ['id' => $comment->id]));
    }

    /**
     * confirm destroy of the specified resource from storage.
     *
     * @param \Illuminate\Http\Request     $request
     * @param \Laralum\Blog\Models\Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        return view('laralum::pages.confirmation', [
            'method'  => 'DELETE',
            'message' => __('laralum_blog::general.sure_del_comment', ['comment' => $comment->comment]),
            'action'  => route('laralum::blog.comments.destroy', ['comment' => $comment->id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Laralum\Blog\Models\Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('laralum::blog.posts.show', ['category' => $comment->post->id])->with('success', __('laralum_blog::general.comment_deleted', ['id' => $comment->id]));
    }
}
