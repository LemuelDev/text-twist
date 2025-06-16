@extends('admin.layout')

@section('content')
<div class="flex h-screen">
    @include('admin.sidebar')

    <div class="flex-1 flex flex-col w-full">
        @include('admin.navbar')

        <main class="flex-1 p-6 " id="main-content">
            <div class="w-full">
                <div class="grid gap-6 shadow-xl rounded-xl pt-8">
                    <div class="rounded-xl p-8">
                        <h1 class="lg:text-3xl text-2xl font-bold pb-6 ">Edit Questions</h1>
                        <form action="{{ route('admin.updateWord', $level->id) }}" method="POST" class="grid items-center w-full gap-4 ">
                            @csrf
                            {{-- Use @method('PUT') for RESTful updates if your route is PUT --}}
                            {{-- @method('PUT') --}}

                            <div class="grid grid-cols-2 items-end gap-4 w-full">
                                {{-- Display Mode for this Level (Readonly) --}}
                                <div class="items-center flex justify-end gap-5">
                                    <label class="text-xl font-bold">Mode:</label>
                                    <input type="text" name="mode_display" value="{{ ucfirst($level->mode) }}" readonly class="bg-transparent rounded-md border-2 border-slate-300 px-2 py-2 max-w-[150px] text-center font-bold text-xl">
                                    {{-- You might also want to include a hidden input for the actual mode if it's needed in request --}}
                                    <input type="hidden" name="mode" value="{{ $level->mode }}">
                                </div>

                                <div class="items-center flex justify-end gap-5">
                                    <label class="text-xl font-bold">Level Number:</label>
                                    <input type="number" name="level_number" value="{{ $level->level_number }}" readonly class="bg-transparent rounded-md border-2 border-slate-300 px-2 py-2 max-w-[90px] text-center font-bold text-xl">
                                </div>
                            </div>
                            <div class="grid">
                                <label>Question</label>
                                <input type="text" name="question" value="{{ old('question', $level->question) }}" required class="bg-transparent rounded-md border-2 border-slate-300 px-2 py-2 text-lg w-full">
                            </div>

                            <h4 class="text-center text-lg py-2">Words & Meanings</h4>
                            <div class="grid gap-4 w-full grid-cols-2">
                                @php
                                    // Determine the number of expected words based on the level's mode
                                    $expectedWordsCount = 1; // Default for 'easy'
                                    if ($level->mode == 'intermediate') {
                                        $expectedWordsCount = 2;
                                    } elseif ($level->mode == 'hard') {
                                        $expectedWordsCount = 3;
                                    }
                                @endphp

                                @for ($i = 0; $i < $expectedWordsCount; $i++)
                                    @php
                                        // Get the existing word/meaning if it exists, otherwise provide empty strings
                                        $word = $level->words->get($i); // Use get($i) to safely access collection item
                                    @endphp
                                    <div>
                                        <label>Word {{ $i + 1 }}</label>
                                        {{-- Hidden input for existing word ID to help with updates --}}
                                        <input type="hidden" name="words[{{ $i }}][id]" value="{{ $word->id ?? '' }}">
                                        <input type="text" name="words[{{ $i }}][word]" value="{{ old("words.$i.word", $word->word ?? '') }}" placeholder="Enter word" required class="bg-transparent rounded-md border-2 border-slate-300 px-2 py-2 text-lg w-full shadow-xl">
                                    </div>
                                    <div>
                                        <label>Meaning {{ $i + 1 }}</label>
                                        <input type="text" name="words[{{ $i }}][meaning]" value="{{ old("words.$i.meaning", $word->meaning ?? '') }}" placeholder="Enter meaning" required class="bg-transparent rounded-md border-2 border-slate-300 px-2 py-2 text-lg w-full shadow-xl">
                                    </div>
                                @endfor
                            </div>

                            <button type="submit" class="text-white rounded-md px-4 py-3 text-lg bg-purple-500 hover:bg-purple-600 text-center whitespace-nowrap max-w-[300px] mx-auto">Update Level</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- Error Modal (keep this as-is from previous successful setup) --}}
@if ($errors->any())
<dialog id="my_modal_39" class="modal">
  <div class="modal-box">
    <h3 class="text-xl font-bold text-red-600">Validation Failed!</h3>
    <p class="py-4 pt-8 text-center">Please correct the following issues:</p>
    <ul class="list-disc list-inside text-left text-red-500">
        @foreach ($errors->all() as $error)
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
    window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('my_modal_39').showModal();
    });
</script>
@endif

{{-- Success Modal --}}
@if (session()->has('success'))
<dialog id="my_modal_40" class="modal">
    <div class="modal-box">
        <h3 class="text-xl font-bold">Success!</h3>
        <p class="py-4 pt-8 text-center">{{session('success')}}</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('my_modal_40').showModal();
    });
</script>
@endif

{{-- Failed Session Message Modal (if you still use this for non-validation errors) --}}
@if (session()->has('failed'))
<dialog id="my_modal_39" class="modal"> {{-- Be careful if my_modal_39 is also for validation errors --}}
    <div class="modal-box">
        <h3 class="text-xl font-bold">Failed!</h3>
        <p class="py-4 pt-8 text-center ">{{session('failed')}}</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>
<script>
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