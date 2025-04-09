<x-ezim::ezimeeting>
    @section('content')

    <div class="flex flex-col items-center justify-center py-16 bg-gray-200">
        <div class="container mx-auto px-4">
            @include('ezimeeting::livewire.includes.heading.admin-heading')
    
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- User Edit Section -->
                <div class="md:col-span-2">
                    <div class="p-4">
                        @livewire('userEdit', ['user' => $user])
                    </div>
                </div>
                <!-- User Roles Section -->
                <div>
                    <div class="p-4">
                        @livewire('userRole', ['user' => $user])
                    </div>
                </div>
            </div>
    
            <!-- Back Button -->
            <div class="mt-6 flex">
                <a href="{{ route('corpUsers') }}" 
                   class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition duration-200">
                    ← Back
                </a>
            </div>
        </div>
    </div>
    

    @endsection
</x-ezim::ezimeeting>