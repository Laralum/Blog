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

class PostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('laralum_blog::laralum.posts.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'category' => 'required|exists:laralum_blog_categories,id',
            'content' => 'required|max:2000',
        ]);

        if (Settings::first()->text_editor == "markdown") {
            $msg = Markdown::convertToHtml($request->content);
        } elseif (Settings::first()->text_editor == "wysiwyg") {
            $msg = $request->content;
        } else {
            $msg = htmlentities($request->content);
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $msg,
            'user_id' => Auth::id(),
            'category_id' => $request->category,
        ]);
        return redirect()->route('laralum::blog.categories.show', ['category' => $request->category])
            ->with('success', __('laralum_blog::general.category_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Laralum\Blog\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('laralum_blog::.laralum.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Laralum\Blog\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('laralum_blog::.laralum.posts.edit', ['post' => $post, 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Blog\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $this->validate($request, [
            'title' => 'required|max:255',
            'category' => 'required|exists:laralum_blog_categories,id',
            'description' => 'required|max:255',
            'content' => 'required|max:2000',
        ]);

        if (Settings::first()->text_editor == "markdown") {
            $msg = Markdown::convertToHtml($request->content);
        } elseif (Settings::first()->text_editor == "wysiwyg") {
            $msg = $request->content;
        } else {
            $msg = htmlentities($request->content);
        }

        $post->update([
            'title' => $request->title,
            'category_id' => $request->category,
            'description' => $request->description,
            'content' => $msg,
        ]);

        return redirect()->route('laralum::blog.posts.show', ['post' => $post])
            ->with('success', __('laralum_blog::general.post_updated', ['id' => $post->id]));
    }

    /**
     * confirm destroy of the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request, Post $post)
    {
        $this->authorize('delete', $post);
        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('laralum_blog::general.sure_del_post', ['post' => $post->title]),
            'action' => route('laralum::blog.posts.destroy', ['post' => $post->id]),
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->deleteComments();
        $post->delete();
        return redirect()->route('laralum::blog.categories.index')
            ->with('success', __('laralum_blog::general.post_deleted',['id' => $post->id]));
    }
}
