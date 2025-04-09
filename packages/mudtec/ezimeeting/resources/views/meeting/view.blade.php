<x-ezim::ezimeeting>
    @section('content')
    
    <div class="flex bg-gray-200 m-5 gap-4 items-stretch">
        <!-- Left side (Meeting + Minutes stacked) -->
        <div class="flex flex-col w-full sm:w-3/5 gap-4">
            <div class="p-5 bg-gray-400 border border-gray-800 h-full">
                <div class="card-body">
                    <!-- Meeting Detail content goes here -->
                    @livewire('MeetingDetail', ['meetingId' => $meetingId, 'state' => 'view'])
                </div>
            </div>
            <div class="p-5 bg-gray-400 border border-gray-800">
                <div class="card-body">
                    <!-- Minutes content goes here -->
                    @livewire('MeetingMinutesView', ['meetingId' => $meetingId, 'minutesId' => $minutesId])
                </div>
            </div>
        </div>
    
        <!-- Right side (Delegates spanning full height) -->
        <div class="flex-1 w-full sm:w-2/5">
            <div class="p-5 bg-gray-400 border border-gray-800 h-full">
                <div class="card-body">
                    <!-- Delegates content goes here -->
                    @livewire('MeetingDelegateRoles', ['meetingId' => $meetingId, 'corpId' => $corpId])
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 w-full text-center flex justify-center items-center mx-5 mt-5 mb-5">
        <a class="px-4 py-2 bg-blue-600 text-white rounded-md"
            href=" {{ route('meetingList') }}">← Back</a>
    </div>

    @endsection
</x-ezim::ezimeeting>