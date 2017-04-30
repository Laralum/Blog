<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Laralum\Blog\Models\Category;

class PublicCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(20);

        return view('laralum_blog::public.categories.index', ['categories' => $categories]);
    }

    /**
     * Display the specified resource.
     *
     * @param \Laralum\Blog\Models\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $posts = $category->posts()->orderByDesc('id')->paginate(10);

        return view('laralum_blog::public.categories.show', ['category' => $category, 'posts' => $posts]);
    }
}
