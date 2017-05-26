{{--
In this file you have the following variables available:

$posts - Posts that will be displayed

--}}
@php
    $settings = \Laralum\Blog\Models\Settings::first();
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_blog::general.category_posts') - {{ \Laralum\Settings\Models\Settings::first()->appname }}</title>
        <link rel="stylesheet" href="{{ \Laralum\Laralum\Packages::css() }}">
    </head>
    <body>
        <h1>@lang('laralum_blog::general.category_posts')</h1>
        <div>
            @if ($posts->count())
                @foreach ($posts as $post)
                    <card>
                        <img src="{{ $post->image }}" alt="">
                        <h3>{{ $post->title }}</h3>
                        <p><time datetime="2016-04-01T19:00">{{ $post->created_at->diffForHumans() }}</time></p>
                        <p>{{ $post->description }}</p>
                        <a href="{{ route('laralum_public::blog.posts.show', ['post' => $post->id]) }}" >@lang('laralum_blog::general.view_post')</a>
                        @if($settings->comments_system == 'laralum' && !$settings->public_permissions)
                            <span>{{ trans_choice('laralum_blog::general.comments_choice', $post->comments->count(), ['num' => $post->comments->count()]) }}</span>
                        @endif
                    </card>
                @endforeach
            @else
                <card>
                    <h3>@lang('laralum_blog::general.no_posts_yet')</h3>
                </card>
            @endif
        </div>
    </div>
    </body>
</html>
