<article class="c2dl-newscard">
    <div class="c2dl-newscard-title" itemscope itemtype="http://schema.org/Article" role="banner">
        <h2 itemprop="name" class="c2dl-newscard-title-text">{{ $entry->title }}</h2>
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
    </div>
    <div itemprop="articleBody" class="c2dl-newscard-preview-text" role="main">
        {{ $entry->preview->content }}
    </div>
    <div class="c2dl-newscard-nav" role="navigation">
        @if ($entry->page->number == 1)
        <a class="c2dl-bottom-nav-element" href="{{ route('news', $entry->id) }}" title="{{ __('home.read_desc', ['title' => $entry->title ]) }}">{{ __('home.read_more', ['title' => $entry->title ]) }}</a>
        @else
            @foreach ($entry->page->list as $page)
        <a class="c2dl-bottom-nav-element" href="{{ route('news', [ $entry->id, ($page == 1 ? null : $page) ]) }}" title="{{ __('home.page_desc', ['title' => $entry->title, 'pagenum' => $page ]) }}">@if ($loop->first)<span itemprop="pageStart">@endif @if ($loop->last)<span itemprop="pageEnd">@endif{{ __('home.page', [ 'pagenum' => $page ]) }} @if ($loop->first)</span>@endif @if ($loop->last)</span>@endif</a>
            @endforeach
        @endif
    </div>
</article>
