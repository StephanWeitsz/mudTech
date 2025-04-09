<div class="bg-white shadow-md rounded-lg p-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">User Roles</h3>
    <!-- User Role Selection -->
    <form wire:submit.prevent="saveUser">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            @foreach ($roles as $role)
                <label class="flex items-center space-x-2 bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition duration-200 cursor-pointer">
                    <input type="checkbox" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring focus:ring-blue-500" 
                        wire:click="toggleRole({{ $role->id }})"
                        @if(in_array($role->id, $selectedRoles)) checked @endif>
                    <span class="text-gray-700">{{ $role->description }}</span>
                </label>
            @endforeach
        </div>
    </form>
    
</div>
