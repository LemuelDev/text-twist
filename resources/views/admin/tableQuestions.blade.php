@if (count($words) > 0)
<div class="overflow-x-auto mt-4">
  <table class="table w-auto">
    <!-- head -->
    <thead>
      <tr>
        <th class="text-lg text-center text-white ">Level Number</th>
        <th class="text-lg text-center text-white">Words to Solve</th>
        <th class="text-lg text-center text-white">Meaning</th>
        <th class="text-lg text-center text-white">Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
     @forelse ($words as $word)
     <tr>
        <td class="max-lg:min-w-[100px] min-w-[100px] text-center text-md">{{$word->level->level_number}}</td>
        <td class="min-w-[350px] text-center text-md">{{$word->word}} 🤔</td>
        <td class="min-w-[500px] text-center text-md">{{ $word->meaning}}</td>
        <td class="text-center text-md flex justify-center items-center gap-2">
          <a href="{{route('admin.editWord', $word->level->id)}}" class="btn btn-secondary text-white">Edit</a>
          <button class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800" onclick="document.getElementById('delete_modal_{{$word->id}}').showModal()">Delete</button>
          
          <!-- Unique Modal for Each Word -->
          <dialog id="delete_modal_{{$word->id}}" class="modal">
              <div class="modal-box">
                  <h3 class="text-lg font-bold">Confirm</h3>
                  <p class="py-2">Are you sure you want to delete this word?</p>
          
                  <!-- Word Submission Form -->
                  <form action="{{ route('admin.deleteWord', $word->id) }}" method="POST">
                      @csrf
                      <div class="modal-action">
                          <button type="submit" class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800">Delete</button>
                          <button type="button" class="btn" onclick="document.getElementById('delete_modal_{{$word->id}}').close()">Close</button>
                      </div>
                  </form>
              </div>
          </dialog>
        </td>
    </tr>
     @empty
         
     @endforelse

    
    
    </tbody>
  </table>
</div>
<div class="mt-4 flex flex-row justify-end items-center gap-4 px-4 text-white ">
  {{ $words->links() }}
</div>
@else
<div class="flex flex-col mt-10 items-center justify-center">
  <div class="text-3xl font-bold  mb-4">No Words to Solve</div>
  <p class="text-xl mb-6">It looks like there are no words to solve at the moment.</p>
</div> 
 @endif