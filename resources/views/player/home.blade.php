@extends('player.layout')

@section('content')
  {{-- content --}}
    <nav class="flex gap-6 justify-end pr-4 items-center pt-6 pb-4">

        <a href="{{route('player.profile')}}" class="text-lg text-white hover:text-white rounded-md outline-none hover:no-underline bg-purple-500 hover:bg-purple-600 px-6 py-3 ">
            Profile
        </a>

        <div class="flex justify-end gap-4 items-center">
            <button class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800" onclick="my_modal_1.showModal()">Logout</button>
            {{-- modal --}}
       
                <dialog id="my_modal_1" class="modal">
                  <div class="modal-box">
                    {{-- <h3 class="text-xl font-bold">Confirmation</h3> --}}
                    <p class="pt-4 text-lg text-center">Are you sure you want to logout ?</p>
                    <div class="modal-action">
                      <form action="{{route("logout")}}" method="POST">
                        @csrf
                        <button class="rounded-md px-8 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800">Logout</button>
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

    <div class="pt-16">
        <div class="flex justify-center items-center flex-col gap-2 rounded-md outline-none  max-w-[600px] mx-auto  p-8">
            <h4 class="text-center ">Text Twist Game</h4>
            <p class="text-xl pt-1 text-yellow-200 text-center">Computer Programming Edition!</p>
            <h5 class="text-lg text-center ">HIGH SCORE:  {{auth()->user()->userProfile->highscore}} </h5>
            <a href="{{route('player.newGame')}}" class="text-xl rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-4 px-8 hover:no-underline hover:text-white">Let's Play</a>
        </div>
    </div>


@endsection