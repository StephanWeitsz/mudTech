<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')
    </div>
    
    @include('ezimeeting::livewire.includes.warnings.success')
    @include('ezimeeting::livewire.includes.warnings.error')
       
    <!-- Corporations List -->
    <div class="container mx-auto bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 w-150 h-150">
            @foreach ($corporations as $corporation)
                <button wire:click="showCorporation({{ $corporation->id }})"
                        class="w-100 h-100 px-4 py-2 rounded-lg 
                        {{ verify_corp($corporation->id) ? 'bg-green-400 text-white' : 'bg-blue-400 text-red' }}">
                    <div class="flex flex-col items-center">
                        <h3 class="text-lg font-semibold mb-2 h-32 flex items-center justify-center items-center">{{ $corporation->name }}</h3>
                        <div class="bg-white p-3">
                            <div class="w-40 h-40 rounded-full overflow-hidden border border-gray-300 shadow-md">
                                <img src="{{ asset($corporation->logo) ?? 'https://placehold.co/150' }}" 
                                     alt="{{ $corporation->name }}" 
                                     class="w-full h-full object-cover flex items-center justify-center">
                            </div>
                        </div>
                    </div>
                </button>
            @endforeach
            <div class="flex justify-center mt-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($viewModal)
        <div class="fixed z-10 inset-0 overflow-y-auto flex items-center justify-center bg-gray-800 bg-opacity-80">  
            <div class="bg-white p-8 rounded-lg shadow-xl max-w-2xl w-full border border-gray-300">
                <div class="bg-gray-300 p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-900">Corporation Details</h3>
                </div>
                @include('ezimeeting::livewire.includes.warnings.success')
                @include('ezimeeting::livewire.includes.warnings.error')
                
                <div class="flex flex-col bg-gray-200 border border-gray-300 mt-4">
                <p class="text-sm text-gray-700 p-2">Name: {{ $selectedCorporation->name ?? '' }}</p>
                <p class="text-sm text-gray-700 p-2">eMail: {{ $selectedCorporation->email ?? '' }}</p>
                <p class="text-sm text-gray-700 p-2">Website: {{ $selectedCorporation->website ?? '' }}</p>
                </div>

                <div class="flex items-center mt-4">
                    <input wire:model.lazy="passcode" type="text" class="px-4 py-2 border rounded-lg" placeholder="Enter Passcode">
                </div>

                <div class="flex justify-between mt-4">
                    <button wire:click="usePasscode"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Submit Corporate Passcode
                    </button>
                    <button wire:click="sendJoinRequest"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Send Join Request
                    </button>
                    <button wire:click="closeModal" 
                            class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
