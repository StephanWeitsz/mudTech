<x-ezim::ezimeeting>
    @section('content')
    
    <div class="flex bg-gray-200 m-5 gap-4">
        <!-- Left side (Meeting + Minutes stacked) -->
        <div class="flex flex-col w-full">
            <div class="p-5 bg-gray-400 border border-gray-800">
                <div class="card-body">
                    @livewire('newMeetingDelegates', ['meetingId' => $meetingId, 'corpId' => $corpId])
                </div>
            </div>
        </div>
    </div>

    @endsection
</x-ezim::ezimeeting>