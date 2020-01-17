@extends('layouts.app')

@section('content')
<div class="dataentry-content">
  <div class="dataentry-main">
    <h1>{{ __('tools.name') }}</h1>
      @foreach ($tool_list as $tool)
      @dataentry([ 'data' => $tool ])
      @endnewscard
      @endforeach
  </div>
</div>
@endsection
