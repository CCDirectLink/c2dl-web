@extends('layouts.app')

@section('title')
{{ __('tools.title') }}
@endsection

@section('content')
<div class="dataentry-content">
  <div class="dataentry-main">
    <h1>{{ __('tools.name') }}</h1>
      @foreach ($tool_info->list as $tool)
      @toolentry([ 'data' => $tool ])
      @endtoolentry
      @endforeach
      @if ($tool_info->maxPage != 1)
      <nav class="c2dl-dataentry-nav">
          @if($tool_info->page > 1)
          <a class="c2dl-bottom-nav-element c2dl-link-before" rel="prev" href="{{ route('mods', [ $tool_info->page - 1 ]) }}">
              {!! __('pagination.previous') !!}</a>
          @endif
          @for ($i = 1; $i <= $tool_info->maxPage; ++$i)
          @if ($i == $tool_info->page)
          <span class="c2dl-bottom-nav-element c2dl-current-page">Page @if ($i == 1)<span itemprop="pageStart">@endif @if ($i == $tool_info->maxPage)<span itemprop="pageEnd">@endif{{ $i }} @if ($i == 1)</span>@endif @if ($i == $tool_info->maxPage)</span>@endif</span>@else
          <a class="c2dl-bottom-nav-element c2dl-link-number" href="{{ route('mods', [ $i ]) }}">Page @if ($i == 1)<span itemprop="pageStart">@endif @if ($i == $tool_info->maxPage)<span itemprop="pageEnd">@endif{{ $i }} @if ($i == 1)</span>@endif @if ($i == $tool_info->maxPage)</span>@endif</a>
          @endif
          @endfor
          @if($tool_info->page < $tool_info->maxPage)
          <a class="c2dl-bottom-nav-element c2dl-link-next" rel="next" href="{{ route('mods', [ $tool_info->page + 1 ]) }}">{!! __('pagination.next') !!}</a>
          @endif
      </nav>
      @endif
  </div>
</div>
@endsection
