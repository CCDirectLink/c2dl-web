<a class="c2dl-newscard-cardlink" href="{{ route('news', $entry->id) }}"><article class="c2dl-newscard">
    <header class="c2dl-newscard-title">
        <h1 class="c2dl-newscard-title-text">{{ $entry->title }}</h1>
        <div class="c2dl-newscard-info">
            <span class="c2dl-newscard-info-elem c2dl-newscard-author">{{ $entry->author->name }}</span>
            <span class="c2dl-newscard-info-elem c2dl-newscard-sep">&nbsp;–&nbsp;</span>
            <span class="c2dl-newscard-info-elem c2dl-newscard-created">{{ $entry->created() }}</span>
            @if ($entry->is_updated())
                <span class="c2dl-newscard-info-elem c2dl-newscard-updated">(last update {{ $entry->updated() }})</span>
            @endif
        </div>
    </header>
    <main class="c2dl-newscard-preview-text">
        {{ $entry->preview->content }}
    </main>
    <nav class="c2dl-newscard-nav">
        @if ($entry->page->number == 1)
        <a class="c2dl-news-nav-element" href="{{ route('news', $entry->id) }}">{{ __('home.read_more') }}</a>
        @else
            @foreach ($entry->page->list as $page)
            <a class="c2dl-news-nav-element" href="{{ route('news', [ $entry->id, ($page == 1 ? null : $page) ]) }}">{{ __('home.page') }} {{ $page }}</a>
            @endforeach
        @endif
    </nav>
</article></a>
