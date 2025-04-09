<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.admin-heading')
    </div>
    
    @include('ezimeeting::livewire.includes.warnings.success')
    @include('ezimeeting::livewire.includes.warnings.error')

    <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-3/4">
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model="name" id="name" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
                @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="text" class="block text-sm font-medium text-gray-700">About</label>
                <textarea wire:model="text" id="text" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
                @error('text') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                <input type="text" wire:model="website" id="website" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('website') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">eMail</label>
                <input type="text" wire:model="email" id="email" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" wire:model="logo" id="logo" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('logo') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="secret" class="block text-sm font-medium text-gray-700">Secret</label>
                <input type="password" wire:model="secret" id="secret" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                @error('secret') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div wire:loading wire:target="logo">
                <span class="text-green-500 m-2">Uploading ...</span>
            </div>
            @if($logo)
                <div class="flex flex-col items-center justify-center py-4 px-6 mb-5 bg-yellow-100 rounded-md shadow-md">
                    <span class="text-gray-900"><h2>Preview</h2></span>
                    <img class="rounded w-32 h-32 mt-5 mb-5 block" src="{{ $logo->temporaryUrl() }}" alt="">
                </div>
            @endif

            <div class="flex items-center justify-between w-full">
                <a href="{{ route('corporations') }}" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
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
