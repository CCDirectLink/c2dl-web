<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" @yield('htmlExt')>
	<head>
		<title>@yield('title')</title>

		<meta charset="utf-8"/>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="noindex, nofollow, noarchive"/>
		<meta name="referrer" content="never"/>
		<meta name="referrer" content="no-referrer"/>

        <link rel="icon" href="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-16x16.png" type="image/png" sizes="16x16" />
        <link rel="icon" href="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-32x32.png" type="image/png" sizes="32x32" />
        <link rel="icon" href="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-64x64.png" type="image/png" sizes="64x64" />
        <link rel="icon" href="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-128x128.png" type="image/png" sizes="128x128" />
        <link rel="icon" href="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-256x256.png" type="image/png" sizes="256x256" />
        <link rel="icon" href="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-512x512.png" type="image/png" sizes="512x512" />

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
                @if (Route::has('about'))
                <li class="c2dl-menu-entry">
                    <a class="c2dl-menu-link" href="{{ route('about') }}" title="{{ __('info.desc') }}">{{ __('info.about') }}</a>
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
