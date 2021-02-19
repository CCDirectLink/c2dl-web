<header class="c2dl-header" role="banner">
    @isNotTextBrowser
        @menudrawer(['title' => $title, 'desc' => $desc])
            {{ $slot }}
        @endmenudrawer
    @endisNotTextBrowser
    @menucontainer(['title' => $title, 'desc' => $desc])
        {{ $slot }}
    @endmenucontainer
</header>
