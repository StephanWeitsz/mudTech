<div>
    <div class="flex flex-col items-center justify-center pt-16 pb-4 bg-gray-200">
        <div class="container mx-auto px-4">
            @include('ezimeeting::livewire.includes.heading.admin-heading')
        </div>

        @include('ezimeeting::livewire.includes.warnings.success')
        @include('ezimeeting::livewire.includes.warnings.error')

        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-full">
            <form wire:submit.prevent="{{ $intervalId ? 'updateInterval' : 'createInterval' }}" class="space-y-4 pb-4">
                <div class="mb-4">
                    <label class="block text-gray-600">Description</label>
                    <input type="text" wire:model="description" placeholder="Enter description"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-600">Text</label>
                    <input type="text" wire:model="text" placeholder="Enter text"
                        class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    @error('text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 w-1/5">
                    <label class="block text-gray-600">Order</label>
                    <input type="number" wire:model="order" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 w-1/5">
                    <label class="block text-gray-600">Date Formula</label>
                    <input type="text" wire:model="formula" class="w-full p-2 border rounded focus:ring focus:ring-blue-300">
                    @error('formula') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="w-5 h-5">
                    <label for="is_active" class="text-gray-600">Active</label>
                    @error('is_active') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="w-full flex gap-2">
                    <button type="submit"
                        class="{{ $intervalId ? 'w-1/3' : 'w-1/3' }} py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg transition">
                        {{ $intervalId ? 'Update' : 'Save' }} Interval
                    </button>
                    
                    @if ($intervalId)
                        <button type="button" wire:click="onCancelInterval"
                            class="w-1/3 py-2 text-white bg-gray-500 hover:bg-gray-600 rounded-lg transition">
                            Cancel
                        </button>
                    @endif
                </div>       

                <div wire:loading.delay>
                    <span class="text-green-500 m-2">Sending ...</span>
                </div>
            </form>
        </div>
    </div>
        
    <div class="flex flex-col items-center justify-center py-2 bg-gray-200">
        <div class="container mx-auto px-4">
            <div class="bg-white shadow-md rounded-lg p-6">
                <table class="min-w-max table-fixed w-full pb-4">
                    <thead>
                        <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Text</th>
                            <th class="py-3 px-6 text-left">Order</th>
                            <th class="py-3 px-6 text-left">Active</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($intervals as $interval)
                            <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $interval->description }}</td>
                                <td class="py-3 px-6 text-left truncate">{{ $interval->text }}</td>
                                <td class="py-3 px-6 text-left">{{ $interval->order }}</td>
                                <td class="py-3 px-6 text-left">
                                    <button wire:click="toggleActive({{ $interval->id }})"
                                            class="px-3 py-1 text-white rounded {{ $interval->is_active ? 'bg-green-500' : 'bg-gray-500' }}">
                                            {{ $interval->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="py-3 px-6 text-left space-x-2">
                                    <button wire:click="editInterval({{ $interval->id }})"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
                                    <button wire:click="deleteInterval({{ $interval->id }})"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>