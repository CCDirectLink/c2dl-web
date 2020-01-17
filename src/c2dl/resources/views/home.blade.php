@extends('layouts.app')

@section('content')
<div class="home-content">
    <article class="home-main">
        <header>
            <h1>{{ __('home.news') }}</h1>
        </header>
        <main class="c2dl-news-list">
            @foreach ($news_list as $news)
                @newscard(['entry' => $news ])
                @endnewscard
            @endforeach
        </main>
    </article>
    <div class="home-sidebar">
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
        <article>
            <header>
                <h1>{{ __('home.social_media') }}</h1>
            </header>
            <main class="c2dl-social-list">
                @foreach ($social as $social_entry)
                @socialcard([ 'entry' => $social_entry ])
                @endsocialcard
                @endforeach
            </main>
        </article>
    </div>
</div>
@endsection
