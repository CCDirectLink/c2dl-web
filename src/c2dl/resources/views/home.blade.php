@extends('layouts.app')

@inject('socialController', 'App\Http\Controllers\SocialController')
@inject('newsController', 'App\Http\Controllers\NewsController')

@section('title')
{{ __('home.title') }}
@endsection

@section('content')
<div class="home-content">
    <article class="home-main">
        <header>
            <h1>{{ __('home.news') }}</h1>
        </header>
        <main class="c2dl-news-list">
            @foreach ($newsController::getNewsList(true) as $news)
                @newscard(['entry' => $news ])
                @endnewscard
            @endforeach
        </main>
    </article>
    <div class="home-sidebar">
        @if (false)
        <article>
            <header>
                <h1>{{ __('home.media') }}</h1>
            </header>
            <main>
                <ul>
                    <li><a class="mediaEntry" href="#" rel="noopener" target="_blank">
                            CrossCode Ultimate Logo Package (xx.x MiB / zip)
                    </a></li>
                    <li><a class="c2dl-media-link" href="#" rel="noopener" target="_blank">
                            CCDirectLink Logo Package (xx.x MiB / zip)
                    </a></li>
                </ul>
            </main>
        </article>
        @endif
        <article>
            <header>
                <h1>{{ __('home.social_media') }}</h1>
            </header>
            <main class="c2dl-social-list">
                @foreach ($socialController::getSocial() as $social_entry)
                @socialcard([ 'entry' => $social_entry ])
                @endsocialcard
                @endforeach
            </main>
            @if ($socialController::hasRecommended())
            <header>
                <h1>{{ __('home.recommended') }}</h1>
            </header>
            <main class="c2dl-social-list">
                @foreach ($socialController::getRecommended() as $social_entry)
                @socialcard([ 'entry' => $social_entry ])
                @endsocialcard
                @endforeach
            </main>
            @endif
        </article>
    </div>
</div>
@endsection
