@extends('layouts.app')

@section('content')
<div class="c2dl-news-box">
    <article class="c2dl-news-main">
      <header class="c2dl-news-title">
        <h1 class="c2dl-news-title-text">{{ $entry->title }}</h1>
          <div class="c2dl-news-info">
          <span class="c2dl-news-info-elem c2dl-news-author">{{ $entry->author->name }}</span>
          <span class="c2dl-news-info-elem c2dl-news-sep">&nbsp;–&nbsp;</span>
          <span class="c2dl-news-info-elem c2dl-news-created">{{ $entry->created() }}</span>
          @if($entry->is_updated())
            <span class="c2dl-news-info-elem c2dl-news-updated">(last update: {{ $entry->updated() }})</span>
          @endif
          </div>
      </header>
      <main class="c2dl-news-content">
        {!! $entry->content !!}
      </main>
        @if ($entry->page->number != 1)
        <nav class="c2dl-news-nav">
            @isset($entry->page->before)
                <a class="c2dl-news-nav-element c2dl-link-before" href="{{ route('news', [ $entry->id,  ($entry->page->before == 1 ? null : $entry->page->before) ]) }}">
                    {!! __('pagination.previous') !!}</a>
            @endisset
            @foreach ($entry->page->list as $page)
                @if ($page == $entry->page->current)
                <span class="c2dl-news-nav-element c2dl-current-page">Page {{ $page }}</span>@else
                <a class="c2dl-news-nav-element c2dl-link-number" href="{{ route('news', [ $entry->id, ($page == 1 ? null : $page) ]) }}">Page {{ $page }}</a>
            @endif
            @endforeach
            @isset($entry->page->next)
                <a class="c2dl-news-nav-element c2dl-link-next" href="{{ route('news', [ $entry->id,  $entry->page->next ]) }}">{!! __('pagination.next') !!}</a>
            @endisset
        </nav>
        @endif
    </article>
</div>
@endsection
