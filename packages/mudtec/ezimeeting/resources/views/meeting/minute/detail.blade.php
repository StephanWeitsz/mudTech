<x-ezim::ezimeeting>
    @section('content')
    
    <div class="flex bg-gray-200 m-5 gap-4 items-stretch">
        <!-- Left side (Meeting + Minutes stacked) -->
        <div class="flex flex-col w-full sm:w-3/5 gap-4">
            <div class="p-5 bg-gray-400 border border-gray-800 h-full">
                <div class="card-body">
                    <!-- Meeting Detail content goes here -->
                    @if($minutesId)
                        @livewire('MinuteDetail', ['meetingId' => $meetingId, 'minutesId' => $minutesId])
                    @else
                        @livewire('MinuteDetail', ['meetingId' => $meetingId, 'minutesId' => 0])
                    @endif
                </div>
            </div>
        </div>
    
        <!-- Right side (Delegates spanning full height) -->
        <div class="flex-1 w-full sm:w-2/5">
            <div class="p-5 bg-gray-400 border border-gray-800 h-full">
                <div class="card-body">
                    @if($minutesId) 
                        @livewire('Attendees', ['meetingId' => $meetingId, 'minutesId' => $minutesId])
                    @else
                        @livewire('Attendees', ['meetingId' => $meetingId, 'minutesId' => 0])
                    @endif
                </div>
            </div>
        </div>
    </div>

    @endsection
</x-ezim::ezimeeting>