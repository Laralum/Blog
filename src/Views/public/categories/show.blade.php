<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_blog::general.category_posts') - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
        <link rel="stylesheet" href="https://gitcdn.xyz/repo/24aitor/CLMaterial/master/src/css/clmaterial.min.css">
    </head>
    <body>
        <h1>@lang('laralum_blog::general.category_posts')</h1>
        <div>
            @if ($posts->count())
                @foreach ($posts as $post)
                    <div>
                        <img src="{{ $post->image }}" alt="">
                        <h3>{{ $post->title }}</h3>
                        <p><time datetime="2016-04-01T19:00">{{ $post->created_at->diffForHumans() }}</time></p>
                        <p>{{ $post->description }}</p>
                        <a href="{{ route('laralum_public::blog.posts.show', ['post' => $post->id]) }}" >@lang('laralum_blog::general.view_post')</a>
                        <span>{{ trans_choice('laralum_blog::general.comments_choice', $post->comments->count(), ['num' => $post->comments->count()]) }}</span>
                    </div>
                @endforeach
                {{ $posts->links() }}
            @else
                <div class="uk-width-1-1">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div uk-alert>
                            <p>@lang('laralum_blog::general.no_posts_yet')</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </body>
</html>
