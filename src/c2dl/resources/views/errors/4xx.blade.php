<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" @yield('htmlExt')>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <meta name="referrer" content="never">
    <meta name="referrer" content="no-referrer">

    @icons
    @endicons

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Error {{ $exception->getStatusCode() }}</title>
</head>
<body>
<div class="errorContainer">
    <img class="errorLogo"
         src="https://storage.c2dl.info/assets/images/logo/c2dl/png/CCDirectLink-256x256.png"
         alt="CCDirectLink Logo">
    <div class="errorTextContainer">
        <span class="errorCode">{{ $exception->getStatusCode() }}</span><span class="errorText">
           {{ $exception->getMessage() }}</span>
    </div>
</div>
</body>
</html>
