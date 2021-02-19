@inject('svgController', 'App\Http\Controllers\SvgController')

<div class="c2dl-menu-bar">
    <div class="c2dl-menu-bar-content">
        <img class="c2dl-menu-bar-logo" id="c2dl-menu-bar-logo-1" src="{{ asset('/images/logo/svg/CCDirectLink.min.svg') }}" width="2em" height="2em" alt="CCDirectLink (C2DL) Logo" title="CCDirectLink">
        <div class="c2dl-menu-bar-text">
            <span itemprop="publisher" itemscope itemtype="http://schema.org/Organization" class="c2dl-menu-bar-title">{{ $title }}</span>
            <span class="c2dl-menu-bar-info">{{ $desc }}</span>
        </div>
    </div>
    <nav class="c2dl-menu-bar-nav" id="c2dl-menu-bar-nav-1">
        {{ $slot }}
    </nav>
</div>
