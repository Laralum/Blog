<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;
use Laralum\Blog\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PublicCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('publicCreate', Comment::class);

        $this->validate($request, [
            'comment' => 'required|max:500',
            'post' => 'required|exists:laralum_blog_posts,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post,
            'comment' => $request->comment,
        ]);

        return redirect()->route('laralum_public::blog.posts.show', ['post' => $request->post])
            ->with('success', __('laralum_blog::general.comment_added'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Blog\Models\Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('publicUpdate', $comment);

        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        $comment->update([
            'comment' => $request->comment
        ]);

        return redirect()->route('laralum_public::blog.posts.show', ['post' => $comment->post->id])
            ->with('success', __('laralum_blog::general.comment_updated', ['id' => $comment->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laralum\Blog\Models\Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('publicDelete', $comment);

        $comment->delete();
        return redirect()->route('laralum_public::blog.posts.show', ['post' => $comment->post->id])
            ->with('success', __('laralum_blog::general.comment_deleted', ['id' => $comment->id]));
    }
}
