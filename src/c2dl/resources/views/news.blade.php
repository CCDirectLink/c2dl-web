@extends('layouts.app')

@section('htmlExt')
itemscope itemtype="http://schema.org/Article"
@endsection

@section('title')
{{ __('news.preTitle') . $entry->title . __('news.postTitle') }}
@endsection

@section('head')
<meta name="title" content="{{ $entry->title }}">
<meta itemprop="url" content="{{ route('news', [ $entry->id, ($entry->page->current == 1 ? null : $entry->page->current) ]) }}">

<meta property="og:title" content="{{ $entry->title }}">
<meta property="article:author" content="{{ $entry->author->name }}">
<meta property="og:site_name" content="CCDirectLink (C2DL)">
<meta property="article:published_time" content="{{ $entry->created('c', 'UTC', 'GR') }}">
@if($entry->is_updated())
<meta property="article:modified_time" content="{{ $entry->updated('c', 'UTC', 'GR') }}">
@endif
@endsection

<!-- itemProp="description" -->

@section('content')
<div class="c2dl-news-box">
    <article class="c2dl-news-main">
      <header class="c2dl-news-title">
        <h1 @isset($entry->page->before) itemprop="name" @else itemprop="articleSection" @endisset class="c2dl-news-title-text">{{ $entry->title }}</h1>
          <div class="c2dl-news-info">
          <span itemprop="author" name="author" class="c2dl-news-info-elem c2dl-news-author">{{ $entry->author->name }}</span>
              <span class="c2dl-newscard-info-elem c2dl-newscard-sep" name="separator" hidden>&nbsp;&ndash;&nbsp;</span>
              <time datetime="{{ $entry->created('c', 'UTC', 'GR') }}" itemprop="datePublished" class="c2dl-news-info-elem c2dl-news-created" name="time_created">{!! $entry->created() !!}</time>
          @if($entry->is_updated())
            <time datetime="{{ $entry->updated('c', 'UTC', 'GR') }}" itemprop="dateModified" class="c2dl-news-info-elem c2dl-news-updated" name="time_modified">(last update: {!! $entry->updated() !!})</time>
          @endif
          </div>
      </header>
      <main itemprop="articleBody" class="c2dl-news-content">
        {!! $entry->content !!}
      </main>
        @if ($entry->page->number != 1)
        <nav class="c2dl-news-nav">
            @isset($entry->page->before)
                <a class="c2dl-bottom-nav-element c2dl-link-before" rel="prev" href="{{ route('news', [ $entry->id,  ($entry->page->before == 1 ? null : $entry->page->before) ]) }}">
                    {!! __('pagination.previous') !!}</a>
            @endisset
            @foreach ($entry->page->list as $page)
                @if ($page == $entry->page->current)
                <span class="c2dl-bottom-nav-element c2dl-current-page">Page @if ($loop->first)<span itemprop="pageStart">@endif @if ($loop->last)<span itemprop="pageEnd">@endif{{ $page }} @if ($loop->first)</span>@endif @if ($loop->last)</span>@endif</span>@else
                <a class="c2dl-bottom-nav-element c2dl-link-number" href="{{ route('news', [ $entry->id, ($page == 1 ? null : $page) ]) }}">Page @if ($loop->first)<span itemprop="pageStart">@endif @if ($loop->last)<span itemprop="pageEnd">@endif{{ $page }} @if ($loop->first)</span>@endif @if ($loop->last)</span>@endif</a>
            @endif
            @endforeach
            @isset($entry->page->next)
                <a class="c2dl-bottom-nav-element c2dl-link-next" rel="next" href="{{ route('news', [ $entry->id,  $entry->page->next ]) }}">{!! __('pagination.next') !!}</a>
            @endisset
        </nav>
        @endif
    </article>
</div>
@endsection
