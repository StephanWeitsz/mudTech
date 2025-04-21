
<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')
    </div>
    
    @include('ezimeeting::livewire.includes.warnings.success')
    @include('ezimeeting::livewire.includes.warnings.error')         

    @if($corpId)
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-3/4">
            <form wire:submit.prevent="store">
                @csrf

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" wire:model="description" id="description" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                    @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="text" class="block text-sm font-medium text-gray-700">Text:</label>
                    <textarea wire:model="text" id="text" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
                    @error('text') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose:</label>
                    <input type="text" wire:model="purpose" id="purposee" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                    @error('purpose') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department:</label>
                    <select wire:model="department_id" id="department-id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                        <option value="">Select a department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Scheduled At:</label>
                    <input type="datetime-local" wire:model="scheduled_at" id="scheduled_at" class="block w-1/4 px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                    @error('scheduled_at') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes):</label>
                    <input type="number" wire:model="duration" id="duration" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                    @error('duration') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="meeting_interval-id">Meeting Interval:</label>
                    <select wire:model="meeting_interval_id" id="meeting_interval_id" name="meeting_interval_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                        <option value="">Select a meeting interval</option>
                        @foreach($intervals as $interval)
                            <option value="{{ $interval->id }}">{{ $interval->description }}</option>
                        @endforeach
                    </select>
                    @error('meeting_interval_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="meeting_location_id">Meeting Location:</label>
                    <select wire:model="meeting_location_id" id="meeting_location_id" name="meeting_location_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                        <option value="">Select a meeting location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->description }}</option>
                        @endforeach
                    </select>
                    @error('meeting_location_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="external_url" class="block text-sm font-medium text-gray-700">Meeting URL:</label>
                    <input type="text" wire:model="external_url" id="external_url" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                    @error('external_url') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
    
                <div class="flex items-center justify-between w-full">
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                        Create Meeting
                    </button>
                    <div wire:loading wite:target="">
                        <span class="text-green-500 m-2">Sending ...</span>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-3/4">
            <div class="mb-4 bg-gray-200 shadow-md rounded-lg p-6">
                <label for="corporation" class="block text-sm font-medium text-gray-700">Select Corporation</label>
                <select id="corporation" wire:change="onCorporationSelected($event.target.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">-- Select Corporation --</option>
                    @foreach($userCorps as $userCorp)
                            <option value="{{ $userCorp->id }}">{{ $userCorp->name }}</option>
                    @endforeach
                </select>
                <div wire:loading wire:target='onCorporationSelected'>
                    <span class="text-green-500 m-2">Searching ...</span>
                </div>
            </div>
        </div> 
    @endif
</div>