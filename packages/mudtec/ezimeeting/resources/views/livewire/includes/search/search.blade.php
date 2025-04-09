<div class="flex items-center mb-4">
    <label for="search" class="block text-sm font-medium text-gray-700 mr-2">Search</label>
    <input wire:model.live.debounce.500ms="search" 
           type="text" 
           placeholder="Search..."
           class="bg-gray-900 text-white ml-2 rounded px-4 py-2 hover:bg-gray-800 w-1/2" />
</div>