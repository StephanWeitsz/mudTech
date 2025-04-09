<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.ezi-full-heading')

        <div class="container mx-auto py-8">
    
            @include('ezimeeting::livewire.includes.warnings.success')
            @include('ezimeeting::livewire.includes.warnings.error')         

            @include('ezimeeting::livewire.includes.search.search')

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-max table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-left">Open Items</th>
                                <th class="py-3 px-6 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            {{--@foreach($meetings as $meeting)--}}
                                <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">                                        
                                        <div class="flex flex-col items-center">
                                            
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        
                                    </td>
                                    <td class="py-3 px-6 text-left">
                        
                                    </td>
                        
                                    <td class="py-3 px-6 text-left items-center justify-between space-x-2">
                                        <div class="flex items-center space-x-2">
                                            
                                            <button wire:click="edit({{ $meeting->id }})" class="text-sm text-black font-semibold rounded hover:text-teal-800 mr-1" title="Edit Meeting">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-8 h-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>

                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--
                @if (!$meetings->isEmpty())
                    {{ $meetings->links() }}
                @endif
                --}}
        </div>
    </div>
</div>