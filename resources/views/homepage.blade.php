<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/jpeg" href="{{ asset('logo-game.jpg') }}">
    <title>Text Twist Game</title>
    @vite('resources/css/app.css')
    {{-- @vite('resources/scss/bg.scss') --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/nes.css/css/nes.min.css">
    
    <style>
        body {
        background-image: url('{{ asset('bg-player.jpg') }}');
        background-size: cover;
        background-repeat: no-repeat;
        }
    </style>
</head>
<body class="min-h-screen  text-white">
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
                bgMusic.volume = 1;

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
     {{-- content --}}
        <div class="flex justify-center text-center items-center flex-col  rounded-md outline-none pt-40">
            <h4>Text Twist Game</h4>
            <p class="text-xl pt-4 text-yellow-200 text-center">Computer Programming Edition!</p>
            <div class="flex justify-center items-center gap-6 py-6 px-4">

                <a href="{{route("login")}}" class="text-xl rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-6 hover:no-underline hover:text-white">Login</a>
                <a href="{{route(name: "signup")}}" class="text-xl rounded-lg outline-none text-white bg-purple-500 hover:bg-purple-600 p-6 hover:no-underline hover:text-white">Signup</a>
            </div>
            <button id="open-modal-btn" class="block text-white bg-gray-800 hover:bg-gray-900 text-sm p-4 rounded-lg ">
                Important Notice
            </button>
        </div>

        <!-- Modal toggle -->

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Important Notice!
                </h3>
                <button type="button" id="close-modal-btn" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-white">
                    This project game is developed by Computer Science Students from President Ramon Magsaysay State University Sta. Cruz Campus for Thesis requirements. This game is inspired by GameHouse but this time it is Computer Programming Edition.!
                </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-end justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <p class="text-base leading-relaxed text-white text-right">
                    All rights reserved @2025
                </p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle modal -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("default-modal");
        const openModalBtn = document.getElementById("open-modal-btn");
        const closeModalBtn = document.getElementById("close-modal-btn");
 

        // Function to show the modal
        function showModal() {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }

        // Function to hide the modal
        function hideModal() {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }

        // Show modal on page load
        showModal();

        // Add event listeners for buttons
        openModalBtn.addEventListener("click", showModal);
        closeModalBtn.addEventListener("click", hideModal);
    });
</script>
    
</body>
</html>