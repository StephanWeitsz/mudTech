<div class="p-4">
    <h2 class="text-lg font-semibold mb-4">Livewire Image Upload</h2>

    @if ($successMessage)
        <div class="mb-4 text-green-600 font-semibold">{{ $successMessage }}</div>
        <img src="{{ asset('storage/' . $path) }}" class="rounded shadow max-w-xs mb-4">
    @endif

    <form wire:submit.prevent="upload" enctype="multipart/form-data">
        <div class="mb-4">
            <input type="file" wire:model="image" class="block w-full text-sm text-gray-500">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div wire:loading wire:target="image" class="text-sm text-gray-500 mb-2">Uploading...</div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>
