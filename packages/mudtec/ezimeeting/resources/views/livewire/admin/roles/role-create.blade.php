<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.admin-heading')
    </div>
    
    @include('ezimeeting::livewire.includes.warnings.success')
    @include('ezimeeting::livewire.includes.warnings.error')
    
    <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-3/4">
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" wire:model="description" id="description" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="text" class="block text-sm font-medium text-gray-700">About</label>
                <textarea wire:model="text" id="text" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
                @error('text') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>      

            <div class="flex items-center justify-between w-full">
                <a href="{{ route('roles') }}" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    ← Back
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    Save
                </button>
            </div>
            <div wire:loading.delay>
                <span class="text-green-500 m-2">Sending ...</span>
            </div>
        </form>
    </div>
</div>