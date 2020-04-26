@inject('svgProvider', 'App\Http\Controllers\SvgProvider')

<div class="c2dl-menu-hamburger" id="c2dl-menu-hamburger-1">
    <label class="c2dl-menu-trigger">
        <input id="c2dl-menu-trigger-t1" type="checkbox" tabindex="0"/>
        <span class="c2dl-menu-trigger-label">Left side drawer switch (Hamburger Menu)</span>
        <span class="c2dl-menu-trigger-hamburger">
            {!! $svgProvider::provide([
                'path' => 'hamburger_icon.svg',
                'class' => 'c2dl-svg-hamburger',
                'id' => 'c2dl-hamburger-icon-1',
                'width' => '2em',
                'height' => '2em'
            ]) !!}
        </span>
        <div class="c2dl-menu-drawer">
            <nav class="c2dl-menu-drawer-nav">
                {{ $slot }}
            </nav>
            <div class="c2dl-menu-drawer-footer">
                <div class="c2dl-menu-drawer-first">
                    {!! $svgProvider::provide([
                        'path' => 'logo.svg',
                        'class' => 'c2dl-menu-drawer-logo',
                        'id' => 'c2dl-menu-drawer-logo-1',
                        'width' => '2em',
                        'height' => '2em'
                    ]) !!}
                    <span class="c2dl-menu-drawer-title">{{ $title }}</span>
                </div>
                <span class="c2dl-menu-drawer-info">{{ $desc }}</span>
            </div>
        </div>
    </label>
</div>
