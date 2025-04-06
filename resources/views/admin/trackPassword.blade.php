@extends('admin.layout')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('admin.sidebar')


    <!-- Main content -->
    <div class="flex-1 flex flex-col w-full">
        <!-- Navbar -->
        @include('admin.navbar')
        
        
        <!-- Main content area -->
        <main class="flex-1 p-6 " id="main-content">
            <div class="w-full">
                <!-- Your main content goes here -->

                        {{-- profile content --}}
                        <div class="grid gap-6 shadow-xl rounded-xl pt-8">
                            {{-- name section --}}
                            <div class="rounded-xl p-8">
                                 <h1 class="lg:text-3xl text-2xl font-bold ">Edit Password 👤</h1>
                                 <form action="{{route('admin.updatePassword')}}" method="POST" class="grid grid-cols-1 max-w-2xl gap-6 pt-5 ">
                                    @csrf
                                        <div class="grid w-full gap-4 ">
                                            <label for="" class="">Current Password:</label>
                                            <input type="password" name="current_password"  class=" border-2 border-slate-400 bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full"  >
                                        </div>
                                        <div class="grid w-full gap-4 ">
                                            <label for="" class="">New Password:</label>
                                            <input type="password" name="new_password"  class=" border-2 border-slate-400 bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                                        </div>
                                        <div class="grid w-full gap-4 ">
                                            <label for="" class="">Confirm Password:</label>
                                            <input type="password" name="new_password_confirmation"  class=" border-2 border-slate-400 bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                                        </div>
                                        <button class="px-10 py-3 rounded-md text-center border-none text-lg text-white shadow bg-green-600 hover:bg-green-700 max-w-[400px] mx-auto">UPDATE PASSWORD</button>
                                 </form>
                            </div>

                        </div>
    

                
            </div>
                       
        </main>
       
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



<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>

@endsection