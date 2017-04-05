<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;
use Laralum\Blog\Models\Comment;

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
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('laralum_blog::public.categories.show', ['category' => $category]);
    }
}
