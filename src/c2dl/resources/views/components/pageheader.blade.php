<header class="c2dl-header">
    @menudrawer(['title' => $title, 'desc' => $desc])
        {{ $slot }}
    @endmenudrawer
    @menucontainer(['title' => $title, 'desc' => $desc])
        {{ $slot }}
    @endmenucontainer
</header>
