@extends('layouts.app')

@section('content')
<div class="c2dl-aboutpage-content">
    <div class="c2dl-aboutpage-main">
        <h1>{{ __('info.team') }}</h1>
        @foreach ($team_list as $team_member)
        @teamcard(['name' => $team_member->name, 'id' => $team_member->id])
        {!! $team_member->bio !!}
        @endteamcard
        @endforeach
    </div>
</div>
@endsection
