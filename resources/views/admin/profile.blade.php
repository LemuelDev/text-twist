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
                                 <h1 class="lg:text-3xl text-2xl font-bold ">Admin Profile 👤</h1>
                                <div class="grid grid-cols-1 max-w-xl gap-6 pt-5 ">
                                    <div class="flex gap-4 justify-start items-center">
                                        <label for="" class="">Username:</label>
                                        <input type="text" readonly value="{{auth()->user()->username}}" class=" bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                                    </div>
                                    <div class="flex gap-4 justify-start items-center">
                                        <label for="" class="">Email:</label>
                                        <input type="text" readonly value="{{auth()->user()->userProfile->email}}" class="  bg-transparent rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                                    </div>
                                </div>  
                            </div>


                            <div class="mx-auto px-4 w-full max-[520px]:max-w-[600px]  max-sm:flex-col flex gap-4 items-center justify-center py-8">
                                <a href="{{route('admin.editProfile')}}" class="px-10 py-3 rounded-md text-center border-none text-lg text-white shadow bg-[#624E88] hover:bg-[#58457b]">Edit Profile</a>
                                <a href="{{route('admin.editPassword')}}" class="px-10 py-3 rounded-md text-center border-none text-lg text-white shadow bg-red-700 hover:bg-red-800">Change Passsword</a>
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
        <p class="py-4 pt-8 text-center ">{{session('failed')}}</p>
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