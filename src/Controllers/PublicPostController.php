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
