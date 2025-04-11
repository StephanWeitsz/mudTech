<x-ezim::ezimeeting>
    @section('content')
        @livewire('MeetingMinutesList', ['meetingId' => $meetingId])   
    @endsection
</x-ezim::ezimeeting>