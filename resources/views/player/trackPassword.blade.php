@extends('player.layout')

@section('content')
{{-- <div class="play text-md max-md:text-center  max-md:pt-4 md:absolute top-5 left-5">Player Profile</div> --}}
        


<nav class="flex gap-5 justify-end max-md:text-sm max-md:justify-center md:pr-6 items-center pt-6 pb-4">
    {{-- <div>
        <h4 class="text-lg"> </h4>
    </div> --}}
    <a href="{{route('player.dashboard')}}" class="text-lg max-md:text-sm text-white rounded-md outline-none hover:no-underline bg-purple-500 hover:bg-purple-700 px-6 py-3 hover:text-white">
        Dashboard
    </a>

    <div class="flex justify-end gap-4 items-center">
        <button class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800 max-md:text-sm" onclick="my_modal_1.showModal()">Logout</button>
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
    
<div class="mt-30 flex justify-center items-center ">
   
        <form action="{{route('player.updatePassword')}}" method="POST" class="grid grid-cols-1 max-w-2xl gap-6 pt-5 rounded-lg shadow-xl px-8 py-8 ">
          @csrf
          <h1 class="text-xl max-md:text-sm font-bold text-center py-3 ">Edit Password</h1>
            <div class="grid w-full gap-4 ">
                <label for="" class="text-lg max-md:text-sm">Current Password:</label>
                <input type="password" name="current_password"  class="nes-input h-full rounded-md outline-none text-black md:text-[16px] text-[16px] bg-white"  >
            </div>
            <div class="grid w-full gap-4 ">
                 <label for="" class="text-lg max-md:text-sm">New Password:</label>
                <input type="password" name="new_password"  class="nes-input h-full rounded-md outline-none text-black md:text-[16px] text-[16px] bg-white">
                 </div>
             <div class="grid w-full gap-4 ">
                    <label for="" class="text-lg max-md:text-sm">Confirm Password:</label>
                    <input type="password" name="new_password_confirmation"  class="nes-input h-full rounded-md outline-none text-black md:text-[16px] text-[16px] bg-white">
            </div>
                <button class="px-10 max-md:text-sm py-3 rounded-md text-center border-none text-lg text-white shadow bg-green-600 hover:bg-green-700 max-w-[400px] mx-auto">UPDATE PASSWORD</button>
         </form>
</div>
   
       
 


@if ($errors->any())
@foreach ($errors->all() as $error)
<dialog id="my_modal_39" class="modal">
    <div class="modal-box">
      <h3 class="text-xl font-bold">Failed!</h3>
      <p class="py-4 pt-8 text-center text-sm">{{$error}}</p>
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



<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>

@endsection