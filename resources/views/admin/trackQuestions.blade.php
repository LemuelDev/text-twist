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
                        <div class="grid  gap-6 shadow-xl rounded-xl pt-8">
                            {{-- name section --}}
                            <div class="rounded-xl p-8">
                                <h1 class="lg:text-3xl text-2xl font-bold pb-6 ">Edit Questions</h1>
                                <form action="{{ route('admin.updateWord', $level->id) }}" method="POST" class="grid items-center w-full gap-4 ">
                                    @csrf
                                
                                    <!-- Level Number (readonly) -->
                                   <div class="grid grid-cols-2 items-end gap-4 w-full">
                                    <!-- Question -->
                                    <div class="items-center flex justify-end gap-5">
                                        <label class="text-xl font-bold">Level Number:</label>
                                        <input type="number" name="level_number" value="{{ $level->level_number }}" readonly class="bg-transparent rounded-md border-2 border-slate-400 py-2 max-w-[90px] text-center font-bold text-xl">
                                    </div>
                                    <div class="grid">
                                       
                                        <label>Question</label>
                                        <input type="text" name="question" value="{{ $level->question }}" required class="bg-transparent rounded-md border-2 border-slate-400 py-2 text-lg w-full">
                                    </div>
                                   </div>
                                
                                    <!-- Existing and Missing Words -->
                                    @php
                                        $words = $level->words; // Eager-loaded in the controller
                                        $totalWords = $words->count();
                                    @endphp
                                
                                    @for ($i = 0; $i < 3; $i++)
                                        <div>
                                            <label>Word and Meaning {{ $i + 1 }}</label>
                                
                                            @if ($i < $totalWords)
                                                {{-- Existing word --}}
                                               <div class="grid gap-4 w-full grid-cols-2">
                                                <input type="hidden" name="words[{{ $i }}][id]" value="{{ $words[$i]->id }}" class="bg-transparent rounded-md border-2 border-slate-400 py-2 text-lg w-full">
                                                <input type="text" name="words[{{ $i }}][word]" value="{{ $words[$i]->word }}" required class="bg-transparent rounded-md border-2 border-slate-400 py-2 text-lg w-full shadow-xl">
                                                <input type="text" name="words[{{ $i }}][meaning]" value="{{ $words[$i]->meaning }}" required class="bg-transparent rounded-md border-2 border-slate-400 py-2 text-lg w-full shadow-xl">
                                               </div>
                                            @else
                                                {{-- Empty word input for missing entries --}}
                                                <div class="grid gap-4 w-full grid-cols-2">
                                                    <input type="text" name="words[{{ $i }}][word]" placeholder="Enter word" required class="bg-transparent rounded-md border-2 border-slate-400 py-2 text-lg w-full shadow-xl">
                                                <input type="text" name="words[{{ $i }}][meaning]" placeholder="Enter meaning" required class="bg-transparent rounded-md border-2 border-slate-400 py-2 text-lg w-full shadow-xl">
                                                </div>
                                            @endif
                                        </div>
                                    @endfor
                                
                                    <button type="submit" class="btn btn-success max-w-[300px] mx-auto">Update Level</button>
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