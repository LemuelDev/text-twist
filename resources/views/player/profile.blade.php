@extends('player.layout')

@section('content')

<div class="play text-lg max-md:text-center" data-splitting>Player Profile</div>
        


<nav class="flex gap-5 justify-end pr-6 items-center pt-6 pb-4">
    {{-- <div>
        <h4 class="text-lg"> </h4>
    </div> --}}
    <a href="{{route('player.dashboard')}}" class="text-lg text-black rounded-md outline-none hover:no-underline bg-purple-500 hover:bg-purple-700 px-6 py-3 hover:text-white">
        Dashboard
    </a>

    <div class="flex justify-end gap-4 items-center">
        <button class="btn btn-error" onclick="my_modal_1.showModal()">Logout</button>
        {{-- modal --}}
   
            <dialog id="my_modal_1" class="modal">
              <div class="modal-box">
                {{-- <h3 class="text-xl font-bold">Confirmation</h3> --}}
                <p class="pt-4 text-lg text-center">Are you sure you want to logout ?</p>
                <div class="modal-action">
                  <form action="{{route("logout")}}" method="POST">
                    @csrf
                    <button class="btn btn-error">Logout</button>
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

<div class="flex justify-center items-center text-center pt-6 px-4 gap-7">
    <h4 class="text-white text-lg">HIGHEST LEVEL CLEARED: <span class="text-yellow-200">{{auth()->user()->userProfile->lvl_cleared}}</span></h4>
    <h4 class="text-white text-lg">HIGHSCORE: <span class="text-yellow-200">{{auth()->user()->userProfile->highscore}} pts</span></h4>
</div>

<div class="grid justify-center items-center grid-cols-1 md:grid-cols-2 gap-4 rounded-md outline-none  max-w-[1000px] mx-auto shadow-xl p-8 max-sm:pt-4">
   
  <div>
       <label for="firstname" class=" text-lg text-center text-white">FirstName:</label>
       <input type="text" id="firstname"  value="{{auth()->user()->userProfile->firstname}}"  name="firstname" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
  </div>
  <div>
    <label for="middlename" class=" text-lg text-center text-white">MiddleName:</label>
    <input type="text" id="middlename" value="{{auth()->user()->userProfile->middlename}}" name="middlename" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
</div>
  <div>
       <label for="lastname" class=" text-lg text-center text-white">Lastname:</label>
       <input type="text" id="lastname"  value="{{auth()->user()->userProfile->lastname}}"  name="lastname" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
   </div>
   <div>
       <label for="studNumber" class=" text-lg text-center text-white">Student Number:</label>
       <input type="text" id="studNumber"  value="{{auth()->user()->userProfile->student_number}}"  name="studNumber" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
  </div>
  <div>
       <label for="year" class=" text-lg text-center text-white">Year:</label>
       <input type="text" id="year"  value="{{auth()->user()->userProfile->year}}" name="year" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
       {{-- <select name="year" id="year" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px]">
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
       </select> --}}
  </div>
   <div>
       <label for="Username" class=" text-lg text-center text-white">Username:</label>
       <input type="text" id="Username"  value="{{auth()->user()->username}}" name="Username" class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white">
  </div>
  <div class="md:col-span-2 md:max-w-[700px] md:mx-auto">
       <label for="email" class=" text-lg text-center text-white">Email:</label>
       <input type="email" id="email" name="email"  value="{{auth()->user()->userProfile->email}}"class="nes-input h-1/2 rounded-md outline-none text-black md:text-[16px] text-[14px] bg-white ">
 </div>
 <div class="flex justify-center items-center gap-8 pt-7 md:col-span-2 md:max-w-[700px] md:mx-auto md:px-10">
    <button class="text-lg rounded-lg outline-none text-white bg-green-500 hover:bg-green-600 p-3  hover:no-underline hover:text-white">
        Edit Profile
   </button>
   <a href="" class="text-lg rounded-lg outline-none text-white bg-slate-500 hover:bg-slate-600 p-3  hover:no-underline hover:text-white">Update Password</a>
 </div>
</div>


@endsection