@inject('svgController', 'App\Http\Controllers\SvgController')

<div class="c2dl-menu-hamburger" id="c2dl-menu-hamburger-1">
    <label class="c2dl-menu-trigger">
        <input id="c2dl-menu-trigger-t1" type="checkbox" tabindex="0"/>
        <span class="c2dl-menu-trigger-label">Left side drawer switch (Hamburger Menu)</span>
        <span class="c2dl-menu-trigger-hamburger">
            {!! $svgController::provide([
                'name' => 'hamburger_icon',
                'class' => 'c2dl-svg-hamburger',
                'id' => 'c2dl-hamburger-icon-1',
                'width' => '2em',
                'height' => '2em'
            ]) !!}
        </span>
        <div class="c2dl-menu-drawer
        @browser('isSafari') c2dl-menu-drawer-safari-bg @else c2dl-menu-drawer-img-bg @endbrowser">
            <nav class="c2dl-menu-drawer-nav">
                {{ $slot }}
            </nav>
            <div class="c2dl-menu-drawer-footer">
                <div class="c2dl-menu-drawer-first">
                    <img class="c2dl-menu-drawer-logo" id="c2dl-menu-drawer-logo-1" src="{{ asset('/images/logo/svg/CCDirectLink.min.svg') }}" width="2em" height="2em" alt="CCDirectLink (C2DL) Logo" title="CCDirectLink">
                    <span class="c2dl-menu-drawer-title">{{ $title }}</span>
                </div>
                <span class="c2dl-menu-drawer-info">{{ $desc }}</span>
            </div>
        </div>
    </label>
</div>
