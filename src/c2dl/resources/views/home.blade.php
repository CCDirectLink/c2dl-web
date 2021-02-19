@extends('layouts.app')

@inject('socialController', 'App\Http\Controllers\SocialController')
@inject('newsController', 'App\Http\Controllers\NewsController')

@section('title')
{{ __('home.title') }}
@endsection

@section('content')
<div class="home-content">
    <div class="home-main">
        <div>
            <h1>{{ __('home.news') }}</h1>
        </div>
        <div class="c2dl-news-list">
            @foreach ($newsController::getNewsList(true) as $news)
                @newscard(['entry' => $news ])
                @endnewscard
            @endforeach
        </div>
    </div>
    <div class="home-sidebar">
        @if (false)
        <div class="home-media">
            <div>
                <h1>{{ __('home.media') }}</h1>
            </div>
            <div>
                <ul>
                    <li><a class="mediaEntry" href="#" rel="noopener" target="_blank">
                            CrossCode Ultimate Logo Package (xx.x MiB / zip)
                    </a></li>
                    <li><a class="c2dl-media-link" href="#" rel="noopener" target="_blank">
                            CCDirectLink Logo Package (xx.x MiB / zip)
                    </a></li>
                </ul>
            </div>
        </div>
        @endif
        <div class="home-social">
            <div class="home-social-content home-social-self-content">
                <div>
                    <h1>{{ __('home.social_media') }}</h1>
                </div>
                <div class="c2dl-social-list">
                    @foreach ($socialController::getSocial() as $social_entry)
                    @socialcard([ 'entry' => $social_entry ])
                    @endsocialcard
                    @endforeach
                </div>
            </div>
            @if ($socialController::hasRecommended())
            <div class="home-social-content home-social-recommend-content">
                <div>
                    <h1>{{ __('home.recommended') }}</h1>
                </div>
                <div class="c2dl-social-list">
                    @foreach ($socialController::getRecommended() as $social_entry)
                    @socialcard([ 'entry' => $social_entry ])
                    @endsocialcard
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
