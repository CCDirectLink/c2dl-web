<li class="c2dl-social c2dl-social-{{ $entry->type }} c2dl-social-cardtype-{{ $entry->card_type }}">
    <div class="c2dl-social-header" role="banner" title="{{ $entry->name }} - {{ $entry->main }}">
        <div class="c2dl-social-container">
            <picture class="{{ 'c2dl-social-logo c2dl-social-'.$entry->type.'-logo' }}"
                     id="c2dl-menu-bar-logo-1"
                     width="22px"
                     height="22px"
                     alt="{{ '['.$entry->name.']' }}"
                     title="{{ $entry->logo }}">
                    <source srcset="{{ asset('https://storage.c2dl.info/assets/images/logo/other/dark/'.$entry->logo) }}"
                            media="(prefers-color-scheme: dark)">
                    <img src="{{ asset('https://storage.c2dl.info/assets/images/logo/other/light/'.$entry->logo) }}">
            </picture>
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
    </div>
    <div class="c2dl-social-nav" role="navigation">
        <a class="c2dl-link-button c2dl-social-link c2dl-social-{{ $entry->type }}-link" rel="noopener" target="_blank"
           href="{{ $entry->link }}" @if ($entry->desc) title="{{ $entry->desc }}" @endif>
            @if ($entry->link_type == 'join')
                {{ __('home.join') }}
            @else
                {{ __('home.visit') }}
            @endif
        </a>
    </div>
</li>
