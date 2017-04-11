<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@lang('laralum_blog::general.category_list') - {{ Laralum\Settings\Models\Settings::first()->appname }}</title>
    </head>
    <body>
        <h1>@lang('laralum_blog::general.category_list')</h1>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('laralum_blog::general.name')</th>
                    <th>@lang('laralum_blog::general.actions')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                                <a href="{{ route('laralum_public::blog.categories.show', ['category' => $category->id]) }}">
                                    @lang('laralum_blog::general.view')
                                </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </body>
</html>
