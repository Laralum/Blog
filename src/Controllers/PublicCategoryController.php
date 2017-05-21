<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;

class PublicCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('laralum_blog::public.categories.index', ['categories' => $categories]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $category
     *
     * @return \Illuminate\Http\Response
     */
    public function show($category = null)
    {
        if (is_null($category)) {
            $posts = Post::all()->where('public', true)->sortByDesc('id');
        } else {
            $posts = Category::findOrFail($category)->posts()->where('public', true)->orderByDesc('id')->get();
        }

        return view('laralum_blog::public.categories.show', ['posts' => $posts]);
    }
}
