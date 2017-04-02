<div class="uk-container uk-container-large">
    <div uk-grid>
        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
        <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    {{ $title }}
                </div>
                <div class="uk-card-body">
                    <form class="uk-form-stacked" method="POST" action="{{ $action }}">
                        {{ csrf_field() }}
                        @if(isset($method)) {{ method_field($method) }} @endif
                        <fieldset class="uk-fieldset">


                            <div class="uk-margin">
                                <label class="uk-form-label">@lang('laralum_blog::general.name')</label>
                                <div class="uk-form-controls">
                                    <input value="{{ old('name', isset($category) ? $category->name : '') }}" name="name" class="uk-input" type="text" placeholder="@lang('laralum_blog::general.name')">
                                </div>
                            </div>

                            <div class="uk-margin">
                            @if(isset($category)) <a href="{{ route('laralum::blog.categories.index') }}" class="uk-button uk-button-default uk-align-left">@lang('laralum_blog::general.cancel')</a> @endif
                                <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                    <span class="ion-forward"></span>&nbsp; {{ $button }}
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
    </div>
</div>
