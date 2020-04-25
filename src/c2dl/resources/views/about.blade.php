@extends('layouts.app')

@section('title')
{{ __('info.title') }}
@endsection

@section('content')
<div class="c2dl-aboutpage-content">
    <div class="c2dl-aboutpage-main">
        <h1>{{ __('info.admins') }}</h1>
        <div class="c2dl-aboutpage-section">
            @foreach ($team_list['admin'] as $team_member)
            @teamcard(['name' => $team_member->name, 'id' => $team_member->id])
            {!! $team_member->bio !!}
            @endteamcard
            @endforeach
        </div>
        <h1>{{ __('info.publicMember') }}</h1>
        <div class="c2dl-aboutpage-section">
            @foreach ($team_list['publicMember'] as $team_member)
            @teamcard(['name' => $team_member->name, 'id' => $team_member->id])
            {!! $team_member->bio !!}
            @endteamcard
            @endforeach
        </div>
    </div>
</div>
@endsection
