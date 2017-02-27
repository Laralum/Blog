<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Post;
use Laralum\Blog\Models\Comment;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laralum_blog::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:50',
            'description' => 'required|max:100',
        ]);
        Category::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Category $category)
    {

        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'action' => route('laralum::blog.categories.destroy', ['category' => $category->id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->deleteComments();
        $category->deletePosts();
        $category->delete();

        return redirect()->route('laralum::blog.categories.index');
    }
}