<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Text-Twist: {{auth()->user()->userProfile->firstname}}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('logo-game.jpg') }}">
    @vite('resources/css/app.css')
    {{-- @vite('resources/scss/bg.scss') --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/nes.css/css/nes.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="min-h-screen bg-[#1B56FD] text-white">

    <audio id="bgMusic" autoplay loop >
        <source src="{{ asset('sounds/bg-sound.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    {{-- adjust bg volume --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgMusic = document.getElementById('bgMusic');

            if (bgMusic) {
                // Set the volume to 30% (0.3)
                // Values range from 0.0 (silent) to 1.0 (full volume)
                bgMusic.volume = 0.7;

                // Handle potential autoplay policy issues:
                // Try to play it if it was blocked. This might still be blocked
                // by some browsers if there's been no user interaction.
                bgMusic.play().catch(error => {
                    console.warn('Background music autoplay was prevented:', error);
                    // You could optionally show a message to the user here
                    // or offer a "click to enable sound" button.
                });
            }
        });
    </script>


    @if (request()->route()->getName() == "player.dashboard" || request()->route()->getName() == "player.newGame" || request()->route()->getName() == "player.nextLevel")
         <div class="play text-md max-md:text-sm max-md:text-center max-md:pt-4 md:absolute top-5 left-5">Player:{{auth()->user()->userProfile->firstname}}</div>
    @endif

     @yield('content')
    

</body>
</html>