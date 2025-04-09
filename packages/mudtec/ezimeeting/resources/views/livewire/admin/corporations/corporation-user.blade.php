<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.admin-heading')
    </div>
    
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

            @include('ezimeeting::livewire.includes.warnings.success')
            @include('ezimeeting::livewire.includes.warnings.error')

            <div class="mb-4">
                <h2 class="p-2">Assign users to a corporation</h2>
                <div wire:loading wite:target='toggleUserAssignment'>
                    <span class="text-green-500 m-2">Selecting ...</span>
                </div>

                @include('ezimeeting::livewire.includes.search.search')

                <div class="flex justify-between">
                    <div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="overflow-x-auto">
                                <h3>Available Users</h3>
                                <table class="min-w-max w-full table-fixed border-collapse border border-gray-200 text-xs sm:text-sm md:text-base">
                                    <thead>
                                        <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Select</th>
                                            <th class="py-3 px-6 text-left">Name</th>
                                            <th class="py-3 px-6 text-left">Email</th>
                                            <th class="py-3 px-6 text-left">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($avaUsers as $user)
                                            <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                                    <input 
                                                        type="checkbox" 
                                                        id="user-{{ $user->id }}" 
                                                        value="{{ $user->id }}" 
                                                        wire:model="assignedUsers"
                                                        wire:click="saveAssignments"
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                    >
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->name }}</td>
                                                <td class="py-3 px-6 text-left sm:w-auto overflow-hidden text-ellipsis whitespace-nowrap truncate">{{ $user->email }}</td>
                                                <td class="py-3 px-6 text-left hidden sm:table-cell">{{ $user->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                                @if(!empty($avaUsers))
                                    <div class="mt-4">
                                        {{ $avaUsers->links() }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="overflow-x-auto">
                                <h3>Assigned Users</h3>
                                <table class="min-w-max w-full table-fixed border-collapse border border-gray-200 text-xs sm:text-sm md:text-base">
                                    <thead>
                                        <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Select</th>
                                            <th class="py-3 px-6 text-left">Name</th>
                                            <th class="py-3 px-6 text-left">Email</th>
                                            <th class="py-3 px-6 text-left">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($assUsers as $user)
                                            <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                                    <input 
                                                        type="checkbox" 
                                                        id="assuser-{{ $user->id }}" 
                                                        value="{{ $user->id }}" 
                                                        wire:model="assignedUsers"
                                                        wire:click="saveAssignments"
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                        checked
                                                    >
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->name }}</td>
                                                <td class="py-3 px-6 text-left sm:w-auto overflow-hidden text-ellipsis whitespace-nowrap truncate">{{ $user->email }}</td>
                                                <td class="py-3 px-6 text-left hidden sm:table-cell">{{ $user->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if(!empty($assUsers))
                                    <div class="mt-4">
                                        {{ $assUsers->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(verify_user("SuperUser|Admin|CorpAdmin"))
                <div class="mt-4">
                    <button wire:click="overRideUsers" class="py-2 px-4 bg-red-500 text-yellow rounded-lg hover:bg-red-600">All Users</button>
                </div>
            @endif

            {{--
            <div class="mt-4">
                <button wire:click="saveAssignments" class="py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save Assignments</button>
            </div>
            <div wire:loading wite:target='saveAssignments'>
                <span class="text-green-500 m-2">Saving ...</span>
            </div>
            --}}
        @endif
    </div>
</div>