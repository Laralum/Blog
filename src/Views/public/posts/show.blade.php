@extends('laralum::layouts.public')
@php
    $settings = \Laralum\Blog\Models\Settings::first();
@endphp
@section('css')
    @if ($settings->text_editor == 'wysiwyg')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.5/tinymce.min.js"></script>
        <script>
            tinymce.init({ selector:'textarea',   plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ] });
        </script>
    @endif
@endsection
@section('title', __('laralum_blog::general.view_post'))
@section('content')
<div>
    <h1>{{ $post->title }}</h1>
    <p>@lang('laralum_blog::general.written_by', ['username' => $post->user->name, 'time_ago' => $post->created_at->diffForHumans(), 'cat' => $post->category->title])</p>

    <p>{!! $post->content !!}</p>
    <br>
    <a href="#comments">{{ trans_choice('laralum_blog::general.comments_choice', $post->comments->count(), ['num' => $post->comments->count()]) }}</a>

    <br><br><br>
    @can('publicAccess', \Laralum\Blog\Models\Comment::class)
                <h3>@if($post->comments->count()) @lang('laralum_blog::general.comments') @else @lang('laralum_blog::general.no_comments_yet') @endif</h3>
                @foreach ($post->comments as $comment)
                    @can('publicView', $comment)
                                    <img src="{{ $comment->user->avatar() }}" width="80" height="80" alt="">
                                    <h4><span>{{ $comment->user->name }}</span></h4>
                                    <ul>
                                        <li><span>{{ $comment->created_at->diffForHumans() }}</span></li>
                                    </ul>
                            <div>
                                @can('publicDelete', $comment)
                                    <form action="{{ route('laralum_public::blog.categories.posts.comments.destroy',['category' => $post->category->id, 'post' => $post->id, 'comment' => $comment->id ]) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" name="button">
                                            @lang('laralum_blog::general.delete')
                                        </button>
                                    </form>
                                @endcan
                                @can('publicUpdate', $comment)
                                    <a href="{{ route('laralum_public::blog.categories.posts.comments.update',['category' => $post->category->id, 'post' => $post->id, 'comment' => $comment->id ]) }}"><i style="font-size:18px;" class="icon ion-edit"></i> @lang('laralum_blog::general.edit')</a>
                                @endcan
                                <p>{!! $comment->comment !!}</p>
                            </div>
                        </article>
                        <br>
                    @endcan
                @endforeach
                @can('publicCreate', \Laralum\Blog\Models\Comment::class)
                            <img src="{{ \Laralum\Users\Models\User::findOrFail(Auth::id())->avatar() }}" width="80" height="80" alt="">
                            <h4><span>{{ \Laralum\Users\Models\User::findOrFail(Auth::id())->name }}</span></h4>

                        <form method="POST" action="{{ route('laralum_public::blog.categories.posts.comments.store',['category' => $post->category->id, 'post' => $post->id]) }}">
                            {{ csrf_field() }}
                            <fieldset>
                                <div>
                                    <br>
                                    @if ($settings->text_editor == 'wysiwyg')
                                        <textarea name="comment">{{ old('comment') }}</textarea>
                                    @else
                                        <textarea name="comment" rows="5" placeholder="{{ __('laralum_blog::general.content') }}">{{ old('comment') }}</textarea>
                                        @if ($settings->text_editor == 'markdown')
                                            <i>@lang('laralum_blog::general.markdown')</i>
                                        @else
                                            <i>@lang('laralum_blog::general.plain_text')</i>
                                        @endif
                                    @endif
                                </div>
                                <div>
                                    <button type="submit">
                                        @lang('laralum_blog::general.submit')
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                @endcan
    @endcan
</div>
@endsection
