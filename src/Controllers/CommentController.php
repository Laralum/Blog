<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;
use Laralum\Blog\Models\Comment;
use Laralum\Blog\Models\Settings;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\Markdown\Facades\Markdown;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category, Post $post)
    {
        $this->authorize('create', Comment::class);

        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        if (Settings::first()->text_editor == "markdown") {
            $msg = Markdown::convertToHtml($request->comment);
        } elseif (Settings::first()->text_editor == "wysiwyg") {
            $msg = $request->comment;
        } else {
            $msg = htmlentities($request->comment);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $msg,
        ]);

        return redirect()->route('laralum::blog.categories.posts.show', ['category' => $category->id, 'post' => $post->id])->with('success', __('laralum_blog::general.comment_sent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        if (Settings::first()->text_editor == "markdown") {
            $msg = Markdown::convertToHtml($request->comment);
        } elseif (Settings::first()->text_editor == "wysiwyg") {
            $msg = $request->comment;
        } else {
            $msg = htmlentities($request->comment);
        }

        $comment->update([
            'comment' => $msg
        ]);

        return redirect()->route('laralum::blog.categories.posts.show', ['category' => $category->id, 'post' => $post->id])->with('success', __('laralum_blog::general.comment_updated', ['id' => $comment->id]));

    }

    /**
     * confirm destroy of the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request, Category $category, Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('laralum_blog::general.sure_del_comment', ['comment' => $comment->comment]),
            'action' => route('laralum::blog.categories.posts.comments.destroy', ['category' => $category->id, 'post' => $post->id, 'comment' => $comment->id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return redirect()->route('laralum::blog.categories.posts.show', ['category' => $category->id, 'post' => $post->id])->with('success', __('laralum_blog::general.comment_deleted', ['id' => $comment->id]));
    }
}
