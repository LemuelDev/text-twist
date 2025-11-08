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
    <div>
        <button class="btn btn-secondary text-white" onclick="my_modal_4.showModal()">Add Word</button>
    <label for="" class="text-sm">Sort by:</label>
         <select name="" id="filter-user" class="py-2 px-4 rounded-lg border border-white-500 text-white">
            <option value="{{route("admin.questions")}}" {{request()->route()->getName() === "admin.questions" ? 'selected' : ''}}>Easy</option>
            <option value="{{route("admin.intermediate")}}"  {{request()->route()->getName() === "admin.intermediate" ? 'selected' : ''}}>Intermediate</option>
             <option value="{{route("admin.hard")}}"  {{request()->route()->getName() === "admin.hard" ? 'selected' : ''}}>Hard</option>
        </select>
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

    <dialog id="my_modal_4" class="modal">
        <div class="modal-box">
            <h3 class="text-xl font-bold text-center">Add a New Word</h3>
            <p class="py-2 text-center">Enter a new word for players to solve.</p>

            <form action="{{ route("admin.addWord") }}" method="POST" class="pt-4">
                @csrf
                <div class="w-full flex flex-col justify-center items-center gap-4 mb-4">
                    {{-- Mode Selection --}}
                    <label for="mode_select" class="text-lg">Select Mode:</label>
                    <select name="mode_select" id="mode_select" class="bg-[#2442c6] text-white rounded-md border-2 border-slate-200 py-2 text-md font-bold text-center w-full" onchange="updateWordFields()">
                        <option value="easy" selected>Easy</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="hard">Hard</option>
                    </select>

                    {{-- Level and Question Input --}}
                    <div class="w-full flex justify-center items-center gap-4 mt-4">
                        <label for="" class="text-lg">Level:</label>
                        {{-- The level number will be dynamically updated by JavaScript --}}
                        <input type="text" name="level_number" id="level_number_input" value="" readonly class="bg-transparent rounded-md border-2 border-slate-200 py-2 text-md font-bold text-center max-w-[90px]">
                        <input type="text" name="question" placeholder="Question" required class="bg-transparent rounded-md border-2 border-slate-200 py-2 text-lg w-full">
                    </div>
                </div>

                <h4 class="text-center text-lg py-2">Words & Meanings</h4>
                <div id="word_meaning_fields" class="grid grid-cols-2 gap-2">
                    {{-- Word and Meaning fields will be dynamically added by JavaScript --}}
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn" onclick="document.getElementById('my_modal_4').close()">Close</button>
                </div>
            </form>
        </div>
    </dialog>
</div>

<script>
    // Store the last known level for each mode. This will be initialized by PHP.
    const lastLevels = {
        'easy': {{ $lastLevels['easy'] ?? 0 }}, // PHP will pass this data
        'intermediate': {{ $lastLevels['intermediate'] ?? 0 }},
        'hard': {{ $lastLevels['hard'] ?? 0 }}
    };

    // Function to update word fields based on selected mode
    function updateWordFields() {
        const modeSelect = document.getElementById('mode_select');
        const wordMeaningFieldsContainer = document.getElementById('word_meaning_fields');
        const levelNumberInput = document.getElementById('level_number_input');
        const selectedMode = modeSelect.value;

        let numQuestions;
        switch (selectedMode) {
            case 'easy':
                numQuestions = 1;
                break;
            case 'intermediate':
                numQuestions = 2;
                break;
            case 'hard':
                numQuestions = 3;
                break;
            default:
                numQuestions = 1; // Default to easy
        }

        // Update the level number input
        levelNumberInput.value = lastLevels[selectedMode] + 1; // Show the next level number

        // Clear existing fields
        wordMeaningFieldsContainer.innerHTML = '';

        // Add new fields based on numQuestions
        for (let i = 0; i < numQuestions; i++) {
            const wordInput = document.createElement('input');
            wordInput.type = 'text';
            wordInput.name = `words[]`;
            wordInput.placeholder = `Word ${i + 1}`;
            wordInput.required = true;
            wordInput.className = 'bg-transparent rounded-md border-2 border-slate-200 py-2 text-lg mt-2';

            const meaningInput = document.createElement('input');
            meaningInput.type = 'text';
            meaningInput.name = `meanings[]`;
            meaningInput.placeholder = `Meaning ${i + 1}`;
            meaningInput.required = true;
            meaningInput.className = 'bg-transparent rounded-md border-2 border-slate-200 py-2 text-lg mt-2';

            wordMeaningFieldsContainer.appendChild(wordInput);
            wordMeaningFieldsContainer.appendChild(meaningInput);
        }
    }

    // Call the function on page load to set initial fields based on default 'easy' mode
    document.addEventListener('DOMContentLoaded', updateWordFields);
</script>

                @include('admin.tableQuestions') 
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

@if ($errors->any()) {{-- Check if there are ANY validation errors --}}
<dialog id="my_modal_39" class="modal">
  <div class="modal-box">
    <h3 class="text-xl font-bold">Validation Failed!</h3> {{-- Make title more specific --}}
    <p class="py-4 pt-8 text-center">Please correct the following issues:</p>
    <ul class="list-disc list-inside text-left">
        @foreach ($errors->all() as $error) {{-- Loop through all error messages --}}
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <div class="modal-action">
      <form method="dialog">
        <button class="btn">Close</button>
      </form>
    </div>
  </div>
</dialog>

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