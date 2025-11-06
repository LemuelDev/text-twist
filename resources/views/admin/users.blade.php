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
                <div class="flex max-sm:flex-col justify-center max-sm:gap-5 sm:justify-between items-center">
                    <h1 class="lg:text-3xl text-2xl font-bold ">Users 👥</h1>
                    {{-- route hereee --}}
                    <div class="flex items-center justify-center gap-4 max-sm:flex-col max-sm:pt-3">
                        <form action="{{ route(request()->route()->getName()) }}" method="GET">
                            <input type="text" placeholder="Search Name" name="search" 
                                class="px-4 py-2 rounded-lg shadow-md border border-white bg-transparent outline-none placeholder:text-white"
                                value="{{ request('search') }}">
                            <button class="py-3 px-6 rounded-lg bg-purple-600 text-white">Search</button>
                        </form>
                        
                    <div>
                        <label for="" class="text-sm">Sort by:</label>
                        <select name="" id="filter-user" class="py-2 px-4 rounded-lg border border-white-500 text-white bg-transparent">
                            <option value="{{route("admin.approveUsers")}}" {{request()->route()->getName() === "admin.approveUsers" ? 'selected' : ''}}>Approved</option>
                            <option value="{{route("admin.pendingUsers")}}"  {{request()->route()->getName() === "admin.pendingUsers" ? 'selected' : ''}}>Pending</option>
                        </select>
                    </div>
                     <script>
                      // Get the select element
                      const filter = document.getElementById('filter-user');
                  
                      // Add an event listener for the change event
                      filter.addEventListener('change', function () {
                          // Redirect to the selected option's value (URL)
                          window.location.href = this.value;
                      });
                  </script>
                    </div>
                </div>

                @include('admin.tableUsers') 
            </div>
                       
        </main>
       
    </div>
</div>

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




<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>

@endsection