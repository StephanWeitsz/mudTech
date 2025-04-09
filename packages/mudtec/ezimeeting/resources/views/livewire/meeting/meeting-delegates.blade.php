<div class="flex flex-col items-center justify-center py-5 bg-gray-200">
    <div class="container mx-auto px-4">
        
        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')
               
        @include('ezimeeting::livewire.includes.warnings.success')
        @include('ezimeeting::livewire.includes.warnings.error')         
    
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-6/7">
            @include('ezimeeting::livewire.includes.search.search')
            <div class="grid grid-cols-12 gap-4">

                <div class="col-span-12 space-y-4">
                   
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="overflow-x-auto">
                                <div class="flex items-end h-16">
                                    <h3 class="flex items-end">Available Users</h3>
                                    <div wire:loading wire:target='assignedUsers' class="ml-2">
                                        <span class="text-green-500">Adding ...</span>
                                    </div>
                                </div>
                                <table class="min-w-max w-full table-fixed border-collapse border border-gray-200 text-xs sm:text-sm md:text-base">
                                    <thead>
                                        <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left w-1/4">Select</th>
                                            <th class="py-3 px-6 text-left">Name & Email</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($avaUsers as $user)
                                            <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                                    <input 
                                                        type="checkbox" 
                                                        id="avauser-{{ $user->id }}" 
                                                        value="{{ $user->id }}" 
                                                        wire:model="assignedUsers"
                                                        wire:click="saveAssignments"
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                    >
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $user->name }}<br>{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>    
                                </table>
                            </div>
                                
                            <div class="overflow-x-auto">
                                <div class="flex justify-between items-end w-full h-16">   
                                    <div class="flex items-center">
                                        <h3>Assigned Users</h3>
                                        <div wire:loading wire:target='removeUsers' class="ml-2">
                                            <span class="text-green-500">Removing ...</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center pb-1">
                                        <button 
                                            wire:click="showAdhocUser" 
                                            class="bg-green-500 text-white rounded-full h-10 w-10 flex items-center justify-center hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                <table class="min-w-max w-full table-fixed border-collapse border border-gray-200 text-xs sm:text-sm md:text-base">
                                    <thead>
                                        <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left w-1/4">Select</th>
                                            <th class="py-3 px-6 text-left">Name & Email</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                        @foreach($assUsers as $assUser)
                                            <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                                <td class="py-3 px-6 text-left">
                                                    <input 
                                                        type="checkbox" 
                                                        id="assuser-{{ $assUser->id }}" 
                                                        value="{{ $assUser->id }}" 
                                                        wire:model="removeUsers"
                                                        wire:click="removeAssignments"
                                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                    >
                                                </td>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $assUser->delegate_name }} <br> {{ $assUser->delegate_email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                </div>
            </div>    
        </div>
    </div>
    
    <!-- Popup Form -->
    @if($displayAdhocUser)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="bg-white rounded-lg p-6 w-1/3">
                <h2 class="text-xl font-semibold mb-4">Add Adhoc User</h2>
                @include('ezimeeting::livewire.includes.warnings.success')
                @include('ezimeeting::livewire.includes.warnings.error')            
                <form wire:submit.prevent="saveAdhocUser">
                    <div class="mb-4">
                        <label for="adhocUserName" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="adhocUserName" wire:model="adhocUserName" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                        @error('adhocUserName') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="adhocUserEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="adhocUserEmail" wire:model="adhocUserEmail" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring-blue-300">
                        @error('adhocUserEmail') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="button" wire:click="hideAdhocUser" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2 hover:bg-gray-600">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

