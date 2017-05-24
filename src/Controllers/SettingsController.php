<?php

namespace Laralum\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Blog\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('update', Settings::class);

        $this->validate($request, [
            'text_editor' => 'required|in:plain-text,markdown,wysiwyg',
            'public_url'  => 'required|max:255',
            'comments_system' => 'required|in:laralum,disqus',
        ]);

        Settings::first()->update([
            'text_editor' => $request->text_editor,
            'public_url'  => $request->public_url,
            'comments_system' => $request->comments_system,
            'disqus_username' => $request->disqus_username
        ]);

        return redirect()->route('laralum::settings.index', ['p' => 'Blog'])->with('success', __('laralum_blog::general.blog_settings_updated'));
    }
}
