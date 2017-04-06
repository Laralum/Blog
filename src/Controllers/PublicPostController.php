<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;

class PublicPostController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Post $post)
    {
        return view('laralum_blog::public.posts.show', ['post' => $post]);
    }
}
