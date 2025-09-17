<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Text Twist - Signup</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('logo-game.jpg') }}">
    @vite('resources/css/app.css')
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
        <h4 class="text-3xl text-center py-4 pt-32 my-0  text-yellow-300">Signup</h4>
         <form action="{{route("users.store")}}" method="POST" class="grid justify-center items-center grid-cols-1 md:grid-cols-2 gap-4 rounded-md outline-none  max-w-[1000px] mx-auto shadow-xl p-8 max-sm:pt-4">
            @csrf
              <div>
                    <label for="firstname" class=" text-lg text-center text-white">FirstName:</label>
                    <input type="text" id="firstname" value="{{old('firstname')}}" name="firstname" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
              </div>
              <div>
                    <label for="middlename" class=" text-lg text-center text-white">MiddleName:</label>
                    <input type="text" id="middlename" value="{{old('middlename')}}" name="middlename" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
              </div>
                <div>
                    <label for="lastname" class=" text-lg text-center text-white">Lastname:</label>
                    <input type="text" id="lastname" value="{{old('lastname')}}"  name="lastname" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
                </div>
              <div>
                    <label for="student_number" class=" text-lg text-center text-white">Student Number:</label>
                    <input type="text" id="student_number" value="{{old('student_number')}}" name="student_number" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
              </div>
              <div>
                <label for="email" class=" text-lg text-center text-white">Email:</label>
                <input type="text" id="email" value="{{old('email')}}" name="email" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
            </div>
              <div>
                    <label for="year" class=" text-lg text-center text-white">Section:</label>
                    <select name="year" id="year" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
                        <option value="" disabled selected>Select Section</option>
                        <option value="1-A">1-A</option>
                        <option value="1-B">1-B</option>
                    </select>
              </div>
                <div>
                    <label for="username" class=" text-lg text-center text-white">Username:</label>
                    <input type="text" id="username" value="{{old('username')}}" name="username" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
              </div>
              <div>
                    <label for="password" class=" text-lg text-center text-white">Password:</label>
                    <input type="password" id="password" name="password" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
              </div>
              <button type="submit" class="text-xl rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-3 md:col-span-2 md:max-w-[400px] md:mx-auto md:px-10 md:py-3 hover:no-underline hover:text-white">
                    Signup
              </button>
              <p class="text-center md:col-span-2 md:max-w-[400px] md:mx-auto text-sm py-3">Already have an account? <a href="{{route("login")}}" class=" hover:no-underline text-yellow-300 hover:text-yellow-400 hover:cale-50">Login</a></p>
            </form>
    
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <dialog id="my_modal_39" class="modal">
            <div class="modal-box">
              <h3 class="text-xl font-bold">Failed!</h3>
              <p class="py-4 pt-8 text-center">{{$error}}</p>
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
      <p class="py-4 pt-8 text-center">{{session('success')}}</p>
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
    <p class="py-4 pt-8 text-center">{{session('failed')}}</p>
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