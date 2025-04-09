<div class="flex flex-col items-center justify-center py-16 bg-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex flex-col bg-gray-400 items-center justify-center mb-12">
            @include('ezimeeting::livewire.includes.heading.admin-heading')
        </div>

        <div class="container mx-auto py-8">
            @include('ezimeeting::livewire.includes.warnings.success')
            @include('ezimeeting::livewire.includes.warnings.error')

            @include('ezimeeting::livewire.includes.search.search')
            
            <div class="bg-white shadow-md rounded-lg p-6">
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
                                        <a href="{{ route('departments', ['corporation'=>$corporation->id]) }}" class="text-sm text-teal-500 font-semibold rounded hover:text-teal-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061A1.125 1.125 0 0 1 3 16.811V8.69ZM12.75 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061a1.125 1.125 0 0 1-1.683-.977V8.69Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('corporationsCreate') }}" class="inline-flex items-center m-2 px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    Add New Record
                </a>
            </div>
        </div>
    
        @if($corporations)
            {{ $corporations->links() }}
        @endif

    </div>
</div>
