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
        <th class="text-lg text-center text-white">Highscore</th>
      
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
     @forelse ($users as $user)
     <tr>
      <td class="max-lg:min-w-[230px] min-w-[250px] text-center">{{$user->firstname}} {{$user->middlename}} {{$user->lastname}}</td>
      <td class="min-w-[230px] text-center">{{$user->user->username}}</td>
      <td class="max-lg:min-w-[200px] min-w-[230px] text-center">{{$user->student_number}}</td>
      <td class="min-w-[200px] text-center">{{$user->year}}</td>
      <td class="min-w-[230px] text-center">{{$user->highscore}} 🔥</td>
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
  <div class="text-3xl font-bold  mb-4">No Leaderboards</div>
  <p class="text-xl mb-6">It looks like there are no users at the moment.</p>
</div> 
 @endif