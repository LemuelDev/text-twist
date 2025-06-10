<aside 
    id="sidebar" 
    class="shadow-xl rounded-lg w-[17rem] bg-[#2442c6] transition-all duration-300 ease-in-out transform lg:translate-x-0 -translate-x-full lg:relative fixed h-full bottom-0 z-[1000]">
    <div class="flex flex-col h-full p-4">
        <div class="flex justify-end">
            <button 
            id="sidebarToggle" 
            class="block lg:hidden focus:outline-none items-end"
            onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />    
                </svg>
            </button>
        </div>

        <ul class="mt-4 flex-grow">
            <li class="mb-2 text-center">
                <a href="#" class="text-center font-bold text-lg flex justify-center items-center gap-2 text-white">
                    ADMIN <span class="pt-2"><box-icon name='user' color="currentColor"></box-icon></span> 
                </a>
            </li>
        
            <li class="mb-2">
                <a href="{{ route('admin.approveUsers') }}" 
                   class="{{ in_array(request()->route()->getName(), ['admin.approveUsers', 'admin.pendingUsers']) ? 'block p-2 bg-gray-700 text-white rounded' : 'block p-2 hover:bg-gray-700 hover:text-white rounded' }}">
                    Users
                </a>
            </li>
        
            <li class="mb-2">
                <a href="{{ route('admin.leaderboards') }}" 
                   class="{{ request()->route()->getName() === 'admin.leaderboards' ? 'block p-2 bg-gray-700 text-white rounded' : 'block p-2 hover:bg-gray-700 hover:text-white rounded' }}">
                    LeaderBoards
                </a>
            </li>
        
            <li class="mb-2">
                <a href="{{route("admin.questions")}}" 
                   class="{{ request()->route()->getName() === 'admin.questions' ? 'block p-2 bg-gray-700 text-white rounded' : 'block p-2 hover:bg-gray-700 hover:text-white rounded' }}">
                    Questions
                </a>
            </li>
        
            <li class="mb-2">
                <a href="{{route("admin.profile")}}" 
                   class="{{ request()->route()->getName() === 'admin.profile' ? 'block p-2 bg-gray-700 text-white rounded' : 'block p-2 hover:bg-gray-700 hover:text-white rounded' }}">
                    Profile
                </a>
            </li>
        </ul>
        
        
        <!-- Footer -->
        <footer class="mt-auto text-center p-2 text-sm border-2 border-gray-400 rounded-lg">
            <p>Text-Twist Game</p>
        </footer>
    </div>
</aside>
