@if (count($users) > 0)
<div class="overflow-x-auto mt-4">
  <table class="table table-zebra w-auto">
    <!-- head -->
    <thead>
      <tr>
        <th class="text-lg text-center text-white ">Name</th>
        <th class="text-lg text-center text-white">Username</th>
        <th class="text-lg text-center text-white">Student Number</th>
        <th class="text-lg  text-center text-white">Section</th>
        <th class="text-lg text-center text-white">Status</th>
        <th class="text-center text-lg text-white">Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
     @forelse ($users as $user)
     <tr>
      <td class="max-lg:min-w-[230px] min-w-[200px] text-center">{{$user->firstname}} {{$user->middlename}} {{$user->lastname}}</td>
      <td class="min-w-[200px] text-center">
        {{ $user->user ? $user->user->username : 'Unknown' }}
    </td>
    
      <td class="max-lg:min-w-[200px] min-w-[200px] text-center">{{$user->student_number}}</td>
      <td class="min-w-[200px] text-center">{{$user->year}}</td>
      <td class="min-w-[200px] text-center">{{$user->isPending}}</td>
      <td class="min-w-[200px] text-center">
        <div class="flex items-center justify-center gap-2">
          <a href="{{route('admin.trackUser', $user->id)}}" class="btn btn-secondary text-white">View</a>
          
          <button class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800" onclick="document.getElementById('delete_modal_{{$user->id}}').showModal()">Delete</button>

          <!-- Unique Modal for Each user -->
          <dialog id="delete_modal_{{$user->id}}" class="modal">
              <div class="modal-box">
                  <h3 class="text-xl font-bold">Confirm</h3>
                  <p class="py-2 text-lg">Are you sure you want to delete this user?</p>
          
                  <!-- Word Submission Form -->
                  <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST">
                      @csrf
                      <div class="modal-action">
                          <button type="submit" class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800">Delete</button>
                          <button type="button" class="btn" onclick="document.getElementById('delete_modal_{{$user->id}}').close()">Close</button>
                      </div>
                  </form>
              </div>
          </dialog>
          </div>
      </td>
    </tr>
     @empty
         
     @endforelse

    
    
    </tbody>
  </table>
</div>
<div class="mt-4 flex flex-row justify-end items-center gap-4 px-4 ">
  {{ $users->links() }}
</div>
@else
<div class="flex flex-col mt-10 items-center justify-center">
  <div class="text-3xl font-bold  mb-4">No Users</div>
  <p class="text-xl mb-6">It looks like there are no users at the moment.</p>
</div> 
 @endif