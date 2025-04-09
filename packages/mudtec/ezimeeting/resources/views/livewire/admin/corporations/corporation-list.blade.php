<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        @include('ezimeeting::livewire.includes.heading.admin-heading')

        <div class="container mx-auto py-8">
            @include('ezimeeting::livewire.includes.warnings.success')
            @include('ezimeeting::livewire.includes.warnings.error')

            @include('ezimeeting::livewire.includes.search.search')

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-max table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-300 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Logo</th>
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Description</th>
                                <th class="py-3 px-6 text-left">Website</th>
                                <th class="py-3 px-6 text-left">Created</th>
                                <th class="py-3 px-6 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($corporations as $corporation)
                            <tr class="border-b border-gray-200 bg-gray-100 hover:bg-gray-200 hover:border-gray-300">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <img src="{{ asset(Storage::url($corporation->logo)) }}" alt="Logo" class="w-32 h-32">
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $corporation->name }}</td>
                                    <td class="py-3 px-6 text-left truncate">{{ $corporation->description }}</td>
                                    <td class="py-3 px-6 text-left truncate">{{ $corporation->website }}</td>
                                    <td class="py-3 px-6 text-left">{{ $corporation->created_at->format('Y-m-d') }}</td>
                                    <td class="py-3 px-6 text-left items-center justify-between space-x-2">
                                        <div class="flex items-center space-x-2">                                       
                                            <a href="{{ route('corporationsUpdate', ['corporation'=>$corporation->id]) }}" class="text-sm text-teal-500 font-semibold rounded hover:text-teal-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-8 h-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <button wire:click="delete({{ $corporation->id }})" class="text-sm text-red-500 font-semibold rounded hover:text-teal-800 mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-8 h-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(verify_user("SupperUser|Apdmin"))
                        <a href="{{ route('corporationsCreate') }}" class="inline-flex items-center m-2 px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                            Add New Record
                        </a>
                    @endif
                </div>
            </div>
        </div>
    
        @if (!$corporations->isEmpty())
            {{ $corporations->links() }}
        @endif

    </div> 
</div>
