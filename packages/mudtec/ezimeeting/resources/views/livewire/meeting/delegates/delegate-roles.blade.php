<div class="flex flex-col items-center justify-center py-5 bg-gray-200">
    <div class="container mx-auto px-4">

        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')
               
        @include('ezimeeting::livewire.includes.warnings.success')
        @include('ezimeeting::livewire.includes.warnings.error')         

        
        <div class="container mx-auto bg-white shadow-md rounded-lg p-6 w-6/7">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center justify-between mb-4">

                            <!-- Ensure the input does not shrink -->
                            <div class="flex-grow w-full">
                                @include('ezimeeting::livewire.includes.search.search')
                            </div>
        
                            <!-- Reserve space for "Saving..." to prevent layout shift -->
                            <div class="ml-2 flex-shrink-0 w-[80px] text-right">
                                <span wire:loading wire:target='setRole' class="text-green-500 whitespace-nowrap">Saving...</span>
                            </div>
                        </div>

                        <table class="min-w-max w-full table-fixed border-collapse border border-gray-200 text-xs sm:text-sm md:text-base">
                            <!-- Force column widths -->
                            <colgroup>
                                <col style="width: 200px;"> <!-- Fixed width for Name & Email -->
                                <col style="width: 20px;" span="{{ count($delegateRoles) }}"> <!-- Auto-fit for roles -->
                            </colgroup>
                        
                            <thead>
                                <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal h-32 align-bottom">
                                    <!-- First Column: Fixed Width for Name & Email -->
                                    <th class="py-3 px-6 text-left">Name & Email</th>
                        
                                    <!-- Role Columns: Auto-fit -->
                                    @foreach($delegateRoles as $role)
                                        <th class="py-3 px-1 text-center">
                                            <div class="transform -rotate-90 whitespace-nowrap">{{$role->description}}</div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>    
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($delegates as $attendee)
                                    <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $attendee->delegate_name }}<br>{{ $attendee->delegate_email }}</td>

                                        @foreach($delegateRoles as $role)
                                            <td class="py-3 px-1 text-center">
                                                <input type="radio" 
                                                        name="role_{{ $attendee->id }}" 
                                                        value="{{ $role->id }}"
                                                        wire:model="assignedRoles.{{ $attendee->id }}"
                                                        wire:click="setRole({{ $attendee->id }}, {{ $role->id }})" 
                                                        {{ $assignedRoles[$attendee->id] == $role->id ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
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

