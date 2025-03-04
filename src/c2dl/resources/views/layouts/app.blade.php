<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" @yield('htmlExt')>
	<head>
		<title>@yield('title')</title>

		<meta charset="utf-8"/>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="noindex, nofollow, noarchive"/>
		<meta name="referrer" content="never"/>
		<meta name="referrer" content="no-referrer"/>

        @icons
        @endicons

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @if(Config::get('app.debug') == 1)
            <link rel="stylesheet" type="text/css" href="/css/.dev.css" media="all" id="c2dl-aditional">
        @endif
        @if(Config::get('app.debug') == 1)
            <script src="/js/.dev.js"></script>
        @endif

        @yield('head')

	</head>
	<body class="c2dl-body">
        @if(Config::get('app.debug') == 1)
            <div class="c2dl-debug-container">
                <code>@yield('debugcontent')</code>
            </div>
        @endif
        <div class="c2dl-content">
            @pageheader([
            'title' => Config::get('app.name'),
            'desc' => __('base.desc')
            ])
            <ul class="c2dl-menu-entry-list">
                @if (Route::has('home'))
                    <li class="c2dl-menu-entry">
                        <a class="c2dl-menu-link" href="{{ route('home') }}" title="{{ __('home.desc') }}">{{ __('home.name') }}</a>
                    </li>
                @endif
                @if (Route::has('mods'))
                    <li class="c2dl-menu-entry">
                        <a class="c2dl-menu-link" href="{{ route('mods') }}" title="{{ __('mods.desc') }}">{{ __('mods.name') }}</a>
                    </li>
                @endif
                @if (Route::has('mods'))
                    <li class="c2dl-menu-entry">
                        <a class="c2dl-menu-link" href="{{ route('tools') }}" title="{{ __('tools.desc') }}">{{ __('tools.name') }}</a>
                    </li>
                @endif
                @if (Route::has('wiki'))
                <li class="c2dl-menu-entry">
                    <a class="c2dl-menu-link" href="{{ route('wiki') }}" title="{{ __('wiki.desc') }}">{{ __('wiki.name') }}</a>
                </li>
                @endif
                @if (false)
                @guest
                    <li class="c2dl-menu-entry">
                        <a class="c2dl-menu-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="c2dl-menu-entry">
                            <a class="c2dl-menu-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                        </li>
                    @endif
                @else
                @endguest
                @endif
            </ul>
            @endpageheader
            <main class="c2dl-main" id="c2dl-main-app" role="main">
                @yield('content')
            </main>
        </div>
	</body>
</html>
