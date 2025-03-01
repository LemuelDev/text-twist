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
       <!-- Main content area -->
       <main class="flex-1 p-6 " id="main-content">
        <div class="w-full">
            <!-- Your main content goes here -->
            <h1 class="text-3xl font-bold pb-4 py-2 tracking-wide max-lg:text-center">Track User</h1>
            
            {{-- profile content --}}
            <div class="grid gap-6 shadow-xl rounded-xl">
                {{-- name section --}}
                <div class="shadow-sm rounded-xl p-8">
                    <h4 class="py-4 text-xl font-bold tracking-wide">User Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 ">
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">FirstName:</label>
                            <input type="text" readonly value="{{$user->firstname}}" class=" bg-transparent rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">MiddleName:</label>
                            <input type="text" readonly value="{{$user->middlename}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">LastName:</label>
                            <input type="text" readonly value="{{$user->lastname}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">Email:</label>
                            <input type="text" readonly value="{{$user->email}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">Student Number:</label>
                            <input type="text" readonly value="{{$user->student_number}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">Year:</label>
                            <input type="text" readonly value="{{$user->year}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">User Type:</label>
                            <input type="text" readonly value="{{$user->user_type}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                        <div class="flex gap-4 justify-start items-center">
                            <label for="">Status:</label>
                            <input type="text" readonly value="{{$user->isPending}}" class="bg-transparent  rounded-lg shadow lg:px-10 px-4 py-3 text-left text-md w-full">
                        </div>
                    </div>  
                </div>

                <div class="mx-auto px-4 w-full max-[520px]:max-w-[600px]  max-sm:flex-col flex gap-4 items-center justify-center py-8">
                    @if ($user->isPending == "approved")
                     <a href="{{route('admin.pending', $user->id)}}" class="text-white rounded-md px-4 py-3 text-lg bg-green-500 hover:bg-green-600 text-center whitespace-nowrap">User to Pending</a>
                    @else
                    <a href="{{route('admin.approved', $user->id)}}" class="text-white rounded-md px-4 py-3 text-lg bg-green-500 hover:bg-green-600 text-center whitespace-nowrap">User to Approved</a>
                 
                    @endif
                    <button class="delete-btn text-white py-3 px-6 bg-red-500 hover:bg-red-600 rounded-md"
                            data-file-id="{{$user->id}}"
                            data-toggle-modal="#deleteConfirmationModal">
                        DELETE
                    </button>
                </div>
            

            </div>

        </div>
                   
    </main>
       
    </div>
</div>



  <!-- Confirmation Modal -->
  <div class="fixed inset-0 z-50 overflow-y-auto hidden" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl max-w-lg mx-auto p-6">
            <div class="modal-header flex justify-start items-center">
                <h5 class="text-lg font-medium" id="deleteConfirmationModalLabel">User Deletion</h5>
            </div>
            <div class="modal-body my-4 text-red-500">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer flex justify-end gap-4">
                <button type="button" class="text-white py-2 px-6 bg-gray-500 hover:bg-gray-600 rounded-md" data-close-modal>Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-white py-2 px-6 bg-red-500 hover:bg-red-600 rounded-md">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Open modal when a button with data-toggle-modal is clicked
    document.querySelectorAll('[data-toggle-modal]').forEach(button => {
        button.addEventListener('click', function() {
            const modalSelector = button.getAttribute('data-toggle-modal');
            const modal = document.querySelector(modalSelector);
            const fileId = button.getAttribute('data-file-id');

            // Ensure fileId is available
            if (fileId) {
                // Set the form action URL
                const deleteForm = modal.querySelector('#deleteForm');
                
                // Construct the URL with the file ID parameter
                const deleteUrl = `/user/delete/${fileId}`;
                
                // Set the form action to the constructed URL
                deleteForm.setAttribute('action', deleteUrl);
                
                // Show the modal
                modal.classList.remove('hidden');
            }
        });
    });

    // Close modal when a button with data-close-modal is clicked
        document.querySelectorAll('[data-close-modal]').forEach(button => {
            button.addEventListener('click', function() {
                const modal = button.closest('#deleteConfirmationModal');
                // Hide the modal
                modal.classList.add('hidden');
            });
        });
    });


</script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>

@endsection