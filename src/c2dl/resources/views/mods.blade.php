@extends('layouts.app')

@section('content')
<div class="dataentry-content">
  <div class="dataentry-main">
    <h1>{{ __('mods.name') }}</h1>
      @foreach ($mod_list as $mod)
        @dataentry([ 'data' => $mod ])
        @endnewscard
      @endforeach
  </div>
</div>
@endsection
