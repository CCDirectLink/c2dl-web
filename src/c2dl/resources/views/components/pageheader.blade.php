<header class="c2dl-header">
    @menudrawer(['title' => $title, 'desc' => $desc, 'icon' => $icon])
        {{ $slot }}
    @endmenudrawer
    @menucontainer(['title' => $title, 'desc' => $desc, 'icon' => $icon])
        {{ $slot }}
    @endmenucontainer
</header>
