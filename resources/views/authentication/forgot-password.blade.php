<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Text Twist - Forgot Password</title>

    @vite('resources/css/app.css')
    @vite('resources/scss/bg.scss')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/nes.css/css/nes.min.css">

</head>
<body>
    
    <div class="scanlines"></div>

    <div class="intro-wrap">
        <div class="noise"></div>
        <div class="noise noise-moving"></div>
        <div class="play text-lg max-md:text-center" data-splitting>Text Twist Game <br> Computer Programming Edition!</div>
        
        {{-- content --}}
       <div class="pt-40">
          <form action="{{route('password.email')}}" method="POST" class="flex justify-center items-center flex-col gap-4 rounded-md outline-none  max-w-[500px] mx-auto shadow-xl p-8 px-8">
              @csrf
              <h4 class="text-xl text-center flex py-3 text-yellow-300">Forgot Password</h4>
              <p class="py-2 text-sm text-center">Enter your email and we will send you a reset password link.</p>
            <div>
                  <label for="email" class=" text-lg text-center text-white">Email:</label>
                  <input type="text" id="email"  name="email" class="nes-input h-1/2 rounded-md outline-none text-black text-[16px] bg-white">
            </div>
          
            <button type="submit" class="text-xl rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-4 hover:no-underline hover:text-white">
                  Submit
            </button>
            <p class="text-center text-sm py-2">Don't have an account yet? <a href="{{route("signup")}}" class=" hover:underline text-fuchsia-900 hover:text-fuchsia-900 hover:cale-50">Signup Here</a></p>
            <p class="text-center md:col-span-2 md:max-w-[400px] md:mx-auto text-sm py-1">Already have an account? <a href="{{route("login")}}" class=" hover:underline text-fuchsia-900 hover:text-fuchsia-900 hover:cale-50">Login</a></p>
          </form>
       </div>


    </div>


    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <dialog id="my_modal_39" class="modal">
        <div class="modal-box">
          <h3 class="text-xl font-bold">Failed!</h3>
          <p class="py-4 pt-8 text-center text-red-600">{{$error}}</p>
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
    <h3 class="text-xl font-bold">Success!</h3>
    <p class="py-4 pt-8 text-center text-green-600">{{session('success')}}</p>
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
    <h3 class="text-xl font-bold">Failed!</h3>
    <p class="py-4 pt-8 text-center text-red-600">{{session('failed')}}</p>
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