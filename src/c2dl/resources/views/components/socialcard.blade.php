@inject('svgProvider', 'App\Http\Controllers\SvgProvider')

<article class="c2dl-social c2dl-social-{{ $entry->type }}">
    <header class="c2dl-social-header">
        <div class="c2dl-social-container">
        {!! $svgProvider::provide([
        'path' => '/ext/'.$entry->logo.'.svg',
        'class' => 'c2dl-social-logo c2dl-social-'.$entry->type.'-logo',
        'width' => '22px',
        'height' => '22px',
        'alt' => '['.$entry->name.']'
        ]) !!}
        <div class="c2dl-social-title">
            <span class="c2dl-social-title-text c2dl-social-{{ $entry->type }}-main">{{ $entry->main }}</span>
            @isset($entry->sub)
                <span class="c2dl-social-title-subtext c2dl-social-{{ $entry->type }}-sub">{{ $entry->sub }}</span>
            @endisset
        </div>
        @isset($entry->side)
        <div class="c2dl-social-sideinfo">
            <span class="c2dl-social-sidetext c2dl-social-{{ $entry->type }}-side">{{ $entry->side }}</span>
        </div>
        @endisset
        </div>
    </header>
    <nav class="c2dl-social-nav">
        <a class="c2dl-link-button c2dl-social-link c2dl-social-{{ $entry->type }}-link" rel="noopener" target="_blank"
           href="{{ $entry->link }}">
            @if ($entry->link_type == 'join')
                {{ __('home.join') }}
            @else
                {{ __('home.visit') }}
            @endif
        </a>
    </nav>
</article>
