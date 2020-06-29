<article class="c2dl-newscard">
    <header class="c2dl-newscard-title" itemscope itemtype="http://schema.org/Article">
        <h1 itemprop="name" class="c2dl-newscard-title-text">{{ $entry->title }}</h1>
        <div class="c2dl-newscard-info">
            @if ($entry->author->hasName())
                <span itemprop="author" name="author" class="c2dl-newscard-info-elem c2dl-newscard-author">{{ $entry->author->name }}</span>
            @else
                <span class="c2dl-newscard-info-elem c2dl-newscard-author c2dl-newscard-authorUnknown">{{ __('news.unknownUser') }}</span>
            @endif
            <span class="c2dl-newscard-info-elem c2dl-newscard-sep" name="separator" hidden>&nbsp;&ndash;&nbsp;</span>
            <time datetime="{{ $entry->created('c', 'UTC', 'GR') }}" itemprop="datePublished" class="c2dl-newscard-info-elem c2dl-newscard-created" name="time_created">{!! $entry->created() !!}</time>
            @if ($entry->is_updated())
                <time datetime="{{ $entry->updated('c', 'UTC', 'GR') }}" itemprop="dateModified" class="c2dl-newscard-info-elem c2dl-newscard-updated" name="time_modified">(last update {!! $entry->updated() !!})</time>
            @endif
        </div>
    </header>
    <main itemprop="articleBody" class="c2dl-newscard-preview-text">
        {{ $entry->preview->content }}
    </main>
    <nav class="c2dl-newscard-nav">
        @if ($entry->page->number == 1)
        <a class="c2dl-bottom-nav-element" href="{{ route('news', $entry->id) }}">{{ __('home.read_more') }}</a>
        @else
            @foreach ($entry->page->list as $page)
        <a class="c2dl-bottom-nav-element" href="{{ route('news', [ $entry->id, ($page == 1 ? null : $page) ]) }}">{{ __('home.page') }} @if ($loop->first)<span itemprop="pageStart">@endif @if ($loop->last)<span itemprop="pageEnd">@endif{{ $page }} @if ($loop->first)</span>@endif @if ($loop->last)</span>@endif</a>
            @endforeach
        @endif
    </nav>
</article>
