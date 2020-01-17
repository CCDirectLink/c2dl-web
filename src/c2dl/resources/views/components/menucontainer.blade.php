<div class="c2dl-menu-bar">
    <div class="c2dl-menu-bar-content">
        <img class="c2dl-menu-bar-logo" id="c2dl-menu-bar-logo-1" src="{{ $icon }}" alt="{{ $title }} Logo" />
        <div class="c2dl-menu-bar-text">
            <span class="c2dl-menu-bar-title">{{ $title }}</span>
            <span class="c2dl-menu-bar-info">{{ $desc }}</span>
        </div>
    </div>
    <nav class="c2dl-menu-bar-nav" id="c2dl-menu-bar-nav-1">
        {{ $slot }}
    </nav>
</div>
