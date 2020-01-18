<div class="c2dl-menu-hamburger" id="c2dl-menu-hamburger-1">
    <label class="c2dl-menu-trigger">
        <input id="c2dl-menu-trigger-t1" type="checkbox" tabindex="0"/>
        <span class="c2dl-menu-trigger-label">Left side drawer switch (Hamburger Menu)</span>
        <span class="c2dl-menu-trigger-hamburger">
            @hamburgersvg([
                'width' => '2em',
                'height' => '2em',
                'className' => 'c2dl-svg-hamburger'
            ])
            @endhamburgersvg
        </span>
        <div class="c2dl-menu-drawer">
            <nav class="c2dl-menu-drawer-nav">
                {{ $slot }}
            </nav>
            <div class="c2dl-menu-drawer-footer">
                <div class="c2dl-menu-drawer-first">
                    <img class="c2dl-menu-drawer-logo" src="{{ $icon }}" alt="{{ $title }} Logo" title="{{ $title }}" />
                    <span class="c2dl-menu-drawer-title">{{ $title }}</span>
                </div>
                <span class="c2dl-menu-drawer-info">{{ $desc }}</span>
            </div>
        </div>
    </label>
</div>
