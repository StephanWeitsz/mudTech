<div class="flex flex-col items-center justify-center py-5 bg-gray-200">
    <div class="container mx-auto px-4">
        
        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')

        @include('ezimeeting::livewire.includes.warnings.success')
        @include('ezimeeting::livewire.includes.warnings.error')    

            {{--py-8--}}
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-6/7">
            <div class="grid grid-cols-12 gap-4">
                <!-- First Column (Smaller Width) -->
                <div class="col-span-4 flex flex-col items-center">
                    <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Corporation</label>
                    <div class="border-2 border-gray-300 rounded-md p-2">
                        <img src="{{ get_corporation_logo($meeting->department_id) ?? 'https://placehold.co/60' }}" 
                             alt="Corporation Logo" class="w-60 h-60 object-cover rounded-md">
                    </div>
                    <p id="title" class="text-lg text-gray-900 text-center mt-2">
                        {{ get_corporation_name($meeting->department_id) }}
                    </p>
                </div>
        
                <!-- Second Column (Larger Width) -->
                <div class="col-span-8 space-y-4">
                    @if($meetingState == 'view')
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <p id="description" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                {{ $meeting_description }}
                            </p>
                        </div>
                        <div class="mb-4">
                            <label for="text" class="block text-sm font-medium text-gray-700">Text</label>
                            <p id="text" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ $meeting_text }}</p>
                        </div>
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                            <p id="purpose" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ $meeting_purpose }}</p>
                        </div>
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department ID</label>
                            <p id="department_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ get_department_name($meeting_department_id) }}</p>
                        </div>
                        <div>
                            <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Scheduled At</label>
                            <p id="scheduled_at" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ $meeting_scheduled_at }}</p>
                        </div>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration (Minutes)</label>
                            <p id="duration" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ $meeting_duration }}</p>
                        </div>
                        <div>
                            <label for="meeting_interval_id" class="block text-sm font-medium text-gray-700">Meeting Interval</label>
                            <p id="meeting_interval_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ get_meeting_interval($meeting_interval_id) }}</p>
                        </div>
                        <div>
                            <label for="meeting_location_id" class="block text-sm font-medium text-gray-700">Meeting Location</label>
                            <p id="meeting_location_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ get_meeting_location($meeting_location_id) }}</p>
                        </div>
                        <div>
                            <label for="external_url" class="block text-sm font-medium text-gray-700">External URL</label>
                            <p id="external_url" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ $meeting->external_url }}</p>
                        </div>
                        <div>
                            <label for="created_by_user_id" class="block text-sm font-medium text-gray-700">Meeting Owner</label>
                            <p id="created_by_user_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">{{ get_user_name($meeting_created_by_user_id) }}</p>
                        </div>

                        <div>
                            <label for="meeting_status_id" class="block text-sm font-medium text-gray-700">Meeting Status</label>
                            <div class="mt-1 flex items-center">
                                <p id="meeting_status_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                    <span class="inline-block w-4 h-4 rounded-full mr-2" style="background-color: {{ get_meeting_color($meeting_status_id) }};"></span>
                                    {{ get_meeting_status($meeting_status_id) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex justify-between">
                                @php
                                    $meeting_status_description = get_meeting_status($meeting_status_id);
                                @endphp
                                @if($meeting_status_description == "New" or
                                    $meeting_status_description == "Active" or 
                                    $meeting_status_description == "In-Progress" or
                                    $meeting_status_description == "reOpend")
                                    <button wire:click="setMeetingStatus('OnHold')" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                                        On Hold
                                    </button>
                                    <button wire:click="setMeetingStatus('Canceled')" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                                        Cancel
                                    </button>
                                    <button wire:click="setMeetingStatus('Closed')" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                                        Close
                                    </button>
                                @endif
                            </div>
                        </div>

                    @elseif($meetingState == 'edit')
                        <div>
                            <form wire:submit.prevent="updateMeeting">
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" 
                                        id="description" 
                                        wire:model="meeting_description" 
                                        class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"
                                    >
                                    @error('meeting_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="text" class="block text-sm font-medium text-gray-700">Text</label>
                                    <textarea id="text" wire:model="meeting_text" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
                                    @error('meeting_text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                                    <textarea id="purpose" wire:model="meeting_purpose" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300"></textarea>
                                    @error('meeting_purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department ID</label>
                                    <select id="department_id" wire:model="meeting_department_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                        @foreach($departments as $dep)
                                            <option value="{{ $dep->id }}" {{ $dep->id == $meeting_department_id ? 'selected' : '' }}>{{ $dep->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('meeting_department_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Scheduled At</label>
                                    <input type="datetime-local" id="scheduled_at" wire:model="meeting_scheduled_at" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                    @error('meeting_scheduled_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration (Minutes)</label>
                                    <input type="number" id="duration" wire:model="meeting_duration" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                    @error('meeting_duration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="meeting_interval_id" class="block text-sm font-medium text-gray-700">Meeting Interval</label>
                                    <select id="meeting_interval_id" wire:model="meeting_interval_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                        
                                        @foreach($meeting_intervals as $interval)
                                            <option value="{{ $interval->id }}" {{ $interval->id == $meeting_interval_id ? 'selected' : '' }}>{{$interval->description }}</option>
                                        @endforeach
                                        
                                    </select>
                                    @error('meeting_interval_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="meeting_location_id" class="block text-sm font-medium text-gray-700">Meeting Location</label>
                                    <select id="meeting_location_id" wire:model="meeting_location_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                        
                                        @foreach($meeting_locations as $location)
                                            <option value="{{ $location->id }}" {{ $location->id == $meeting_location_id ? 'selected' : '' }}>{{ $location->description }}</option>
                                        @endforeach
                                        
                                    </select>
                                    @error('meeting_location_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="external_url" class="block text-sm font-medium text-gray-700">External URL</label>
                                    <input type="url" id="external_url" wire:model="meeting_external_url" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                    @error('meeting_external_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="created_by_user_id" class="block text-sm font-medium text-gray-700">Meeting Owner</label>
                                    <select id="created_by_user_id" wire:model="meeting_created_by_user_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                        
                                        @foreach($corpUsers as $employee)
                                            <option value="{{ $employee->id }}" {{ $employee->id == $meeting_created_by_user_id ? 'selected' : ''}}> {{ $employee->name }} ({{ $employee->email }})</option>
                                        @endforeach
                                        
                                    </select>
                                    @error('meeting_created_by_user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="meeting_status_id" class="block text-sm font-medium text-gray-700">Meeting Status</label>
                                    <div class="mt-1 flex items-center">
                                        <p id="meeting_status_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                            <span class="inline-block w-4 h-4 rounded-full mr-2" style="background-color: {{ get_meeting_color($meeting_status_id) }};"></span>
                                            {{ get_meeting_status($meeting_status_id) }}
                                        </p>
                                    </div>
                                </div>

                                {{--
                                <div class="mb-4">
                                    <label for="meeting_status_id" class="block text-sm font-medium text-gray-700">Meeting Status</label>
                                    <select id="meeting_status_id" wire:model="meeting_status_id" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                                        
                                        @foreach($meeting_statuses as $status)
                                            <option value="{{ $status->id }}" {{ $status->id == $meeting_status_id ? 'selected' : '' }}>{{ $status->description }}</option>
                                        @endforeach
                                        
                                    </select>
                                    @error('meeting_status_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                --}}
                                
                                <div class="mt-4">
                                    <div class="flex justify-between">
                                        <button wire:click="exitEditMeeting" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                                            ← Back
                                        </button>

                                        @php
                                            $meeting_status_description = get_meeting_status($meeting_status_id);
                                        @endphp
                                        @if($meeting_status_description == "Closed" or $meeting_status_description == "Canceled" or $meeting_status_description == "OnHold")
                                            <button wire:click="setMeetingStatus('reOpend')" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                                                Re Open
                                            </button>
                                            <button wire:click="setMeetingStatus('Completed')" class="px-4 py-2 bg-gray-400 text-white rounded-md">
                                                Complete
                                            </button>
                                        @endif

                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                                            Update Meeting
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>    
                    @endif    
                </div>
            </div>
        </div>
    </div>
</div>