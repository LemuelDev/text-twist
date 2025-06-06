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
                    <h1 class="lg:text-3xl text-2xl font-bold ">Questions 🤔</h1>
                    <button class="btn" onclick="my_modal_4.showModal()">Add Word</button>
                    <dialog id="my_modal_4" class="modal">
                      <div class="modal-box">
                          <h3 class="text-xl font-bold text-center">Add a New Word</h3>
                          <p class="py-2 text-center">Enter a new word for players to solve.</p>
                  
                          <!-- Word Submission Form -->
                          <form action="{{route("admin.addWord")}}" method="POST" class="pt-4">
                              @csrf
                             <div class="w-full flex justify-center items-center gap-4">
                              <label for="" class="text-lg">Level:</label>
                              <input type="text" name="level_number" value="{{$nextLevelNumber}}" readonly class="bg-transparent rounded-md border-2 border-slate-200 py-2 text-md font-bold text-center max-w-[90px]">
                              <input type="text" name="question" placeholder="Question" required class="bg-transparent rounded-md border-2 border-slate-200 py-2 text-lg w-full">
                             </div>

                              <h4 class="text-center text-lg py-2">Words & Meanings</h4>
                              <div class="grid grid-cols-2 gap-2">
                                @for ($i = 0; $i < 3; $i++)
                                  <input type="text" name="words[]" placeholder="Word {{ $i+1 }}" required class="bg-transparent rounded-md border-2 border-slate-200 py-2 text-lg mt-2 ">
                                  <input type="text" name="meanings[]" placeholder="Meaning {{ $i+1 }}" required class="bg-transparent rounded-md border-2 border-slate-200 py-2 text-lg mt-2 ">
                              @endfor
                              </div>
                  
                              <!-- Submit and Close Buttons -->
                              <div class="modal-action">
                                  <button type="submit" class="btn btn-primary">Add</button>
                                  <button type="button" class="btn" onclick="document.getElementById('my_modal_4').close()">Close</button>
                              </div>
                          </form>
                      </div>
                  </dialog>
                  
                </div>

                @include('admin.tableQuestions') 
            </div>

           
             
        </main>
       
    </div>
</div>

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