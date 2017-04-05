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
    public function create(Category $category)
    {
        $this->authorize('create', Post::class);
        return view('laralum_blog::laralum.posts.create', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', Post::class);
        $this->validate($request, [
            'title' => 'required|max:255',
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

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $msg,
            'user_id' => Auth::id(),
            'category_id' => $category->id,
        ]);
        return redirect()->route('laralum::blog.categories.show', ['category' => $category->id])->with('success', __('laralum_blog::general.category_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Post $post)
    {
        $this->authorize('view', $post);
        return view('laralum_blog::.laralum.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Post $post)
    {
        $this->authorize('update', $post);
        return view('laralum_blog::.laralum.posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, Post $post)
    {
        $this->authorize('update', $post);
        $this->validate($request, [
            'title' => 'required|min:5|max:60',
            'content' => 'required|max:1500',
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
            'content' => $msg,
        ]);

        return redirect()->route('laralum::blog.categories.posts.show', ['category' => $category, 'post' => $post])->with('success', __('laralum_blog::general.post_updated', ['id' => $post->id]));
    }

    /**
     * confirm destroy of the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request, Category $category, Post $post)
    {
        $this->authorize('delete', $post);
        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('laralum_blog::general.sure_del_post', ['post' => $post->title]),
            'action' => route('laralum::blog.categories.posts.destroy', ['category' => $category->id, 'post' => $post->id]),
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Post $post)
    {
        $this->authorize('delete', $post);
        $post->deleteComments();
        $post->delete();
        return redirect()->route('laralum::blog.categories.show', ['category' => $category->id])->with('success', __('laralum_blog::general.post_deleted',['id' => $post->id]));
    }
}
