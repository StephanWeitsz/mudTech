<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.admin-heading')
    </div>
    
    @include('ezimeeting::livewire.includes.warnings.success')
    @include('ezimeeting::livewire.includes.warnings.error')

    <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-3/4">
        <div class="mb-4 bg-gray-200 shadow-md rounded-lg p-6">
            <label for="corporation" class="block text-sm font-medium text-gray-700">Select Corporation</label>
            <select id="corporation" wire:change="onCorporationSelected($event.target.value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">-- Select Corporation --</option>
                @foreach($corporations as $corporation)
                    <option value="{{ $corporation->id }}">{{ $corporation->name }}</option>
                @endforeach
            </select>
            <div wire:loading wire:target='onCorporationSelected'>
                <span class="text-green-500 m-2">Searching ...</span>
            </div>
        </div>
              
        @if($selectedCorporation)
            <div class="mb-4">
                <div class="flex flex-col items-center justify-center py-4 px-6 mb-5 bg-yellow-100 rounded-md shadow-md">
                    <img src="{{ asset(Storage::url($corporation->logo)) }}" alt="Logo" class="w-32 h-32">
                </div>
            </div>

            <div class="mb-4">
                <h3>Departments</h3>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <table class="min-w-max table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Description</th>
                                <th class="py-3 px-6 text-left">Manager</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($departments as $department)
                                <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $department->name }}</td>
                                    <td class="py-3 px-6 text-left truncate">{{ $department->description }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="relative">

                                            <select id="manager" 
                                                    wire:change="onManagerSelected({{ $department->id }}, $event.target.value)" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="">-- Select Manager --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" 
                                                        {{ isset($managers[$department->id]) && $managers[$department->id]['user_id'] == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div wire:loading wire:target="onManagerSelected" class="absolute top-0 right-0">
                                                <span class="text-green-500 m-2">Saving ...</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>               
            </div>
                 
            <div class="mt-4">
                @if( $departments )
                    {{ $departments->links() }}
                @endif
            </div>
            
        @endif
    </div>
</div>