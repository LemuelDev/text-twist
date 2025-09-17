<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Text Twist - Login</title>
      <link rel="icon" type="image/jpeg" href="{{ asset('logo-game.jpg') }}">
    @vite('resources/css/app.css')
    {{-- @vite('resources/scss/bg.scss') --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/nes.css/css/nes.min.css">

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
     
        {{-- content --}}
       <div class="pt-40">
          <form action="{{route("user.login")}}" method="POST" class="flex justify-center items-center flex-col gap-4 rounded-md outline-none  max-w-[500px] mx-auto shadow-xl p-8 px-8">
              @csrf
              <h4 class="text-3xl text-center flex py-3 text-yellow-300">Login</h4>
            <div>
                  <label for="username" class=" text-lg text-center text-white">Username:</label>
                  <input type="text" id="username"  name="username" class="nes-input h-1/2 rounded-md outline-none text-black text-[16px] bg-white">
            </div>
            <div>
                  <label for="password" class=" text-lg text-center text-white">Password:</label>
                  <input type="password" id="password" name="password" class="nes-input h-1/2 rounded-md outline-none text-black text-[16px] bg-white">
            </div>
            <button type="submit" class="text-xl rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-4 hover:no-underline hover:text-white">
                  Login
            </button>
            <a href="{{ route('password.request') }}" class="text-yellow-300 hover:text-yellow-400 text-center text-sm hover:no-underline  block">Forgot Password?</a>
            <p class="text-center text-sm py-3 text-white">Don't have an account yet? <a href="{{route("signup")}}" class=" text-yellow-300 hover:text-yellow-400 hover:no-underline  ">Signup Here</a></p>
          </form>
       </div>





    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <dialog id="my_modal_39" class="modal">
        <div class="modal-box">
          <h3 class="text-xl font-bold text-white">Failed!</h3>
          <p class="py-4 pt-8 text-center text-white">{{$error}}</p>
          <div class="modal-action">
            <form method="dialog">
              <!-- if there is a button in form, it will close the modal -->
              <button class="btn">Close</button>
            </form>
          </div>
        </div>
        </dialog>
      
         <!-- JavaScript to automatically open modal -->
      <script>
          // Automatically open modal on page load
          window.addEventListener('DOMContentLoaded', (event) => {
          document.getElementById('my_modal_39').showModal();
          });
      </script>
    @endforeach

    @endif

    @if (session()->has('success'))
    <dialog id="my_modal_40" class="modal">
    <div class="modal-box">
    <h3 class="text-xl font-bold text-white">Success!</h3>
    <p class="py-4 pt-8 text-center text-white">{{session('success')}}</p>
    <div class="modal-action">
        <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <button class="btn">Close</button>
        </form>
    </div>
    </div>
    </dialog>

    <!-- JavaScript to automatically open modal -->
    <script>
    // Automatically open modal on page load
    window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('my_modal_40').showModal();
    });
    </script>
    @endif


    @if (session()->has('failed'))
    <dialog id="my_modal_39" class="modal">
    <div class="modal-box">
    <h3 class="text-xl font-bold text-white">Failed!</h3>
    <p class="py-4 pt-8 text-center text-white">{{session('failed')}}</p>
    <div class="modal-action">
    <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <button class="btn">Close</button>
    </form>
    </div>
    </div>
    </dialog>

    <!-- JavaScript to automatically open modal -->
    <script>
    // Automatically open modal on page load
    window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('my_modal_39').showModal();
    });
    </script>
    @endif

    
</body>
</html>