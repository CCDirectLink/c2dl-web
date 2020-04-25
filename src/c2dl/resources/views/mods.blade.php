@extends('layouts.app')

@section('title')
{{ __('mods.title') }}
@endsection

@section('content')
<div class="dataentry-content">
  <div class="dataentry-main">
    <h1>{{ __('mods.name') }}</h1>
      @foreach ($mod_info->list as $mod)
        @modentry([ 'data' => $mod ])
        @endmodentry
      @endforeach
      @if ($mod_info->maxPage != 1)
      <nav class="c2dl-dataentry-nav">
          @if($mod_info->page > 1)
          <a class="c2dl-bottom-nav-element c2dl-link-before" rel="prev" href="{{ route('mods', [ $mod_info->page - 1 ]) }}">
              {!! __('pagination.previous') !!}</a>
          @endif
          @for ($i = 1; $i <= $mod_info->maxPage; ++$i)
          @if ($i == $mod_info->page)
          <span class="c2dl-bottom-nav-element c2dl-current-page">Page @if ($i == 1)<span itemprop="pageStart">@endif @if ($i == $mod_info->maxPage)<span itemprop="pageEnd">@endif{{ $i }} @if ($i == 1)</span>@endif @if ($i == $mod_info->maxPage)</span>@endif</span>@else
          <a class="c2dl-bottom-nav-element c2dl-link-number" href="{{ route('mods', [ $i ]) }}">Page @if ($i == 1)<span itemprop="pageStart">@endif @if ($i == $mod_info->maxPage)<span itemprop="pageEnd">@endif{{ $i }} @if ($i == 1)</span>@endif @if ($i == $mod_info->maxPage)</span>@endif</a>
          @endif
          @endfor
          @if($mod_info->page < $mod_info->maxPage)
          <a class="c2dl-bottom-nav-element c2dl-link-next" rel="next" href="{{ route('mods', [ $mod_info->page + 1 ]) }}">{!! __('pagination.next') !!}</a>
          @endif
      </nav>
      @endif
  </div>
</div>
@endsection
