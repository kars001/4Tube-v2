<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="A dynamic video platform for uploading, streaming, and sharing content. Connect with creators, explore trends, and enjoy seamless viewing!">
    <meta name="keywords"
        content="video platform, streaming, upload videos, share content, watch online, creators, video sharing, trending videos, entertainment, live streaming.">
    <meta name="author" content="Youtube">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="4Tube">
    <meta property="og:description"
        content="Watch, upload, and share videos effortlessly on our dynamic platform. Connect with creators and explore trending content worldwide!">
    <meta property="og:image" content="">
    <meta property="og:url" content="http://127.0.0.1:8000/">
    <meta property="og:type" content="website">

    <link rel="shortcut icon" href="{{ asset('storage/fav.png') }}" type="image/x-icon">
    <title>@yield('title', '4Tube')</title>
    @vite('resources/css/app.css')

</head>

<body>
    <x-toast/>
    
    {{ $slot }}
</body>

</html>
