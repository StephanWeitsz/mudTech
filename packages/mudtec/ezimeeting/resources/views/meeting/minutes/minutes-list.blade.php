<x-ezim::ezimeeting>
    @section('content')
        @livewire('MinutesList', ['meetingId' => $meetingId])   
    @endsection
</x-ezim::ezimeeting>