<div>
    @if($minutesId)
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-6/7">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-grow w-full">
                                @include('ezimeeting::livewire.includes.search.search')
                            </div>
                            <div class="ml-2 flex-shrink-0 w-[80px] text-right">
                                <span wire:loading wire:target='setRole' class="text-green-500 whitespace-nowrap">Saving...</span>
                            </div>
                        </div>

                        <table class="min-w-max w-full table-fixed border-collapse border border-gray-200 text-xs sm:text-sm md:text-base">
                            <colgroup>
                                <col style="width: 200px;">
                                <col style="width: 20px;" span="{{ count($attendeeStatuses) }}">
                            </colgroup>
                            <thead>
                                <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal h-32 align-bottom">
                                    <th class="py-3 px-6 text-left">Name & Email</th>
                                    @foreach($attendeeStatuses as $status)
                                        <th class="py-3 px-1 text-center">
                                            <div class="transform -rotate-90 whitespace-nowrap">{{$status->description}}</div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>    
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($delegates as $attendee)
                                    <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $attendee->delegate_name }}<br>{{ $attendee->delegate_email }}</td>
                                        @foreach($attendeeStatuses as $status)
                                            <td class="py-3 px-1 text-center">
                                                <input type="radio" 
                                                    name="status_{{ $attendee->id }}" 
                                                    value="{{ $status->id }}"
                                                    wire:model="assignedAttendeeStatus.{{ $attendee->id }}"
                                                    wire:click="setStatus({{ $attendee->id }}, {{ $status->id }})"
                                                    {{ $assignedAttendeeStatus[$attendee->id] == $status->id ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>    
        </div>
    @else
        <div class="text-center bg-yellow-100 text-yellow-800 p-4 rounded-lg shadow-md">
            <strong>⚠ Please capture meeting minutes first.</strong>
        </div>
    @endif
</div>
