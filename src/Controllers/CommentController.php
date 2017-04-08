<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;
use Laralum\Blog\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
        $this->authorize('create', Comment::class);

        $this->validate($request, [
            'comment' => 'required|max:500',
            'post' => 'required|exists:laralum_blog_posts,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post,
            'comment' => $request->comment,
        ]);

        return redirect()->route('laralum::blog.posts.show', ['post' => $request->post])
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
        $this->authorize('update', $comment);

        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        $comment->update([
            'comment' => $request->comment
        ]);

        return redirect()->route('laralum::blog.posts.show', ['post' => $comment->post->id])->with('success', __('laralum_blog::general.comment_updated', ['id' => $comment->id]));

    }

    /**
     * confirm destroy of the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Blog\Models\Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('laralum_blog::general.sure_del_comment', ['comment' => $comment->comment]),
            'action' => route('laralum::blog.comments.destroy', ['comment' => $comment->id]),
        ]);
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
        $this->authorize('delete', $comment);

        $comment->delete();
        return redirect()->route('laralum::blog.posts.show', ['category' => $comment->post->id])->with('success', __('laralum_blog::general.comment_deleted', ['id' => $comment->id]));
    }
}
