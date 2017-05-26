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
            'text_editor'              => 'required|in:plain-text,markdown,wysiwyg',
            'public_url'               => 'required|max:191',
            'comments_system'          => 'required|in:disabled,laralum,disqus',
            'disqus_website_shortname' => 'max:191',
            'public_permissions'       => 'required|boolean',
        ]);

        $settings = Settings::first();

        $settings->update([
            'text_editor'              => $request->text_editor,
            'public_url'               => $request->public_url,
            'comments_system'          => $request->comments_system,
            'disqus_website_shortname' => $request->disqus_website_shortname,
            'public_permissions'       => $request->public_permissions,
        ]);

        $settings->touch();

        return redirect()->route('laralum::settings.index', ['p' => 'Blog'])->with('success', __('laralum_blog::general.blog_settings_updated'));
    }
}
