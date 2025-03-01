<nav class=" shadow p-4">
    <div class="container mx-auto flex justify-between px-4 items-center lg:justify-end gap-4">

      <button class="block lg:hidden" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
       </button>

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
    </div>

   
</nav>


