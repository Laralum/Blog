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
        $this->authorize('view', Category::class);

        $categories = Category::all();
        return view('laralum_blog::laralum.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('laralum_blog::laralum.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $this->validate($request, [
            'name' => 'required|unique:laralum_shop_categories,name|max:255',
        ]);

        Category::create($request->all());
        return redirect()->route('laralum::blog.categories.index')->with('success', __('laralum_blog::general.category_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view', Category::class);

        return view('laralum_blog::laralum.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('laralum_blog::laralum.categories.edit', ['category' => $category]);
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
        $this->authorize('update', $category);

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $category->update($request->all());
        return redirect()->route('laralum::blog.categories.index')->with('success', __('laralum_blog::general.category_updated',['id' => $category->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laralum\Blog\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Category $category)
    {
        $this->authorize('delete', $category);

        return view('laralum::pages.confirmation', [
            'method' => 'DELETE',
            'message' => __('laralum_blog::general.sure_del_category', ['category' => $category->name]),
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
        $this->authorize('delete', $category);

        $category->deleteComments();
        $category->deletePosts();
        $category->delete();

        return redirect()->route('laralum::blog.categories.index')->with('success', __('laralum_blog::general.category_deleted'));
    }
}
