<div class="bg-white shadow-md rounded-lg p-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{$sub_heading}}</h3>
    <div class="pb-5">
        @include('ezimeeting::livewire.includes.warnings.success')
        @include('ezimeeting::livewire.includes.warnings.error')
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Image Section -->
        <div class="flex flex-col items-center">
            <div class="w-40 h-40 rounded-full overflow-hidden border border-gray-300 shadow-md">
                <img src="{{ $user->profile_photo_path ?? 'https://placehold.co/150' }}" 
                     alt="User Profile" 
                     class="w-full h-full object-cover">
            </div>
            
            <!-- Image Upload Button -->
            <label class="mt-4 cursor-pointer px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <input type="file" class="hidden" wire:model="profile_photo">
                Upload New Image
            </label>

            @error('profile_photo') 
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span> 
            @enderror
        </div>

        <!-- User Profile Form -->
        <div class="md:col-span-2">
            <form wire:submit.prevent="saveUser">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-gray-700 font-medium">Name</label>
                        <input 
                            id="name"
                            type="text"
                            wire:model="name"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter user's name"
                        >
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-gray-700 font-medium">Email</label>
                        <input 
                            id="email"
                            type="email"
                            wire:model="email"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter user's email"
                        >
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>        
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end">
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</div>
