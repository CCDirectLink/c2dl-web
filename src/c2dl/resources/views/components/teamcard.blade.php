<div class="c2dl-teamcard">
    <div class="c2dl-teamcard-title">
        <h1 class="c2dl-teamcard-title-text">{{ $name }}</h1>
    </div>
    @if ($bio != null)
    <div class="c2dl-teamcard-text">
        @if (gettype($bio) == 'string')
            {!! $bio !!}
        @else
            <ul>
                @foreach ($bio as $listitem)
                    <li>{{ $listitem }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    @endif
</div>
