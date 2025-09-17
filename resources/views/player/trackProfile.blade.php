@extends('player.layout')

@section('content')

<div class="play text-md max-md:text-center max-md:pt-4 md:absolute top-5 left-5">Player Profile</div>
        


<nav class="flex gap-5 justify-end max-md:justify-center md:pr-6 items-center pt-6 pb-4">
    {{-- <div>
        <h4 class="text-lg"> </h4>
    </div> --}}
    <a href="{{route('player.dashboard')}}" class="text-lg max-md:text-sm text-white rounded-md outline-none hover:no-underline bg-purple-500 hover:bg-purple-700 px-6 py-3 hover:text-white">
        Dashboard
    </a>

    <div class="flex justify-end gap-4 items-center">
        <button class="rounded-md px-4 py-3 outline-none border-none max-md:text-sm text-white bg-red-700 hover:bg-red-800" onclick="my_modal_1.showModal()">Logout</button>
        {{-- modal --}}
   
            <dialog id="my_modal_1" class="modal">
              <div class="modal-box">
                {{-- <h3 class="text-xl font-bold">Confirmation</h3> --}}
                <p class="pt-4 text-lg text-center">Are you sure you want to logout ?</p>
                <div class="modal-action">
                  <form action="{{route("logout")}}" method="POST">
                    @csrf
                    <button class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800">Logout</button>
                  </form>
                  <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Close</button>
                  </form>
                </div>
              </div>
            </dialog>
       

       </div>
    
</nav>
{{-- content --}}



<form method="POST" action="{{route("player.updateProfile")}}" class="grid justify-center items-center grid-cols-1 md:grid-cols-2 gap-4 rounded-md outline-none  max-w-[1000px] mx-auto shadow-xl p-8 max-sm:pt-4">
   @csrf
    <div>
        <label for="firstname" class=" text-lg max-md:text-sm text-center text-white">FirstName:</label>
        <input type="text" id="firstname" required value="{{auth()->user()->userProfile->firstname}}"  name="firstname" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
    </div>
    <div>
        <label for="middlename" class=" text-lg max-md:text-sm text-center text-white">MiddleName:</label>
        <input type="text" id="middlename"  value="{{auth()->user()->userProfile->middlename}}" name="middlename" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
    </div>
    <div>
        <label for="lastname" class=" text-lg max-md:text-sm text-center text-white">Lastname:</label>
        <input type="text" id="lastname" required value="{{auth()->user()->userProfile->lastname}}"  name="lastname" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
    </div>
    <div>
        <label for="studNumber" class=" text-lg max-md:text-sm text-center text-white">Student Number:</label>
        <input type="text" id="studNumber" required value="{{auth()->user()->userProfile->student_number}}"  name="student_number" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
    </div>
    <div>
        <label for="year" class=" text-lg max-md:text-sm text-center text-white">Section:</label>
        <input type="text" id="year" required  value="{{auth()->user()->userProfile->year}}" name="year" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
     
    </div>
    <div>
        <label for="Username" class=" text-lg max-md:text-sm text-center text-white">Username:</label>
        <input type="text" id="Username" required  value="{{auth()->user()->username}}" name="username" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
    </div>
    <div class="md:col-span-2 md:max-w-[700px] md:mx-auto">
        <label for="email" class=" text-lg max-md:text-sm text-center text-white">Email:</label>
        <input type="email" id="email" name="email" required value="{{auth()->user()->userProfile->email}}" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white ">
    </div>
    <div class="md:col-span-2 col-span-1 flex justify-center md:max-w-[700px] md:mx-auto">
        <button class="text-lg max-md:text-sm rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-3  hover:no-underline hover:text-white">
            Update Profile
     </button>
    </div>
       
   
 
<form>

@if ($errors->any())
@foreach ($errors->all() as $error)
<dialog id="my_modal_39" class="modal">
    <div class="modal-box">
      <h3 class="text-xl font-bold">Failed!</h3>
      <p class="py-4 pt-8 text-center  text-sm">{{$error}}</p>
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
<p class="py-4 pt-8 text-center text-sm">{{session('success')}}</p>
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
<p class="py-4 pt-8 text-center text-sm">{{session('failed')}}</p>
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


@endsection