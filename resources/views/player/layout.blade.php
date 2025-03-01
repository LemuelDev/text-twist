<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Text-Twist: {{auth()->user()->userProfile->firstname}}</title>
    @vite('resources/css/app.css')
    @vite('resources/scss/bg.scss')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/nes.css/css/nes.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
    <div class="scanlines"></div>

    <div class="intro-wrap">
        <div class="noise"></div>
        <div class="noise noise-moving"></div>
        @if (request()->route()->getName() !== "player.profile")
            <div class="play text-lg max-md:text-center" data-splitting>Player:{{auth()->user()->userProfile->firstname}}</div>
        @endif
       
        @yield('content')

    </div>
</body>
</html>