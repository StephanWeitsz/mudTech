<div class="flex flex-col items-center justify-center py-5 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.ezi-small-heading')
        <div class="container mx-auto py-3">
            <div class="flex flex-wrap justify-between">
                @if( $meetingStatus == "New" || $meetingStatus == "In-Progress" || $meetingStatus == "Active") 
                    <button wire:click='MeetingMinuteDetails({{ $meetingId }})' class="bg-blue-500 text-white py-5 px-10 rounded mb-2">New</button>
                @endif
                @foreach ($meetingMinutes as $mm)
                    @php
                        $date = \Carbon\Carbon::parse($mm->date)->format('Y-m-d');
                    @endphp
                    <button wire:click='viewMeetingMinutes({{$meetingId}} ,{{ $mm->id }})' 
                            class="bg-gray-500 text-white py-5 px-6 rounded mb-2">
                        {{ $date }} <br> {{ strtoupper($mm->state) }}
                    </button>
                @endforeach
                @if(count($meetingMinutes) == 3)
                    <button wire:click='listMeetingMinutes({{ $meetingId }})' class="bg-green-500 text-white py-5 px-10 rounded mb-2">More...</button>
                @endif
            </div>
                
        </div>        
    </div>
</div>