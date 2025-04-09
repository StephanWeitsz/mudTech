<x-ezim::ezimeeting>
    @section('content')
        <div class="w-full text-center py-24">
            <h1 class="text-2xl md:text-3xl font-bold text-center lg:text-5xl text-gray-700">
                Welcome to <span class="text-yellow-500">{{ config('app.name', 'mudTeck*') }}</span> <span class="text-gray-900"> eziMeeting</span>
            </h1>
            <p class="text-gray-500 text-lg mt-1">Manage meetings with minites and actions on the fly</p>
            <!--
            <a class="px-3 py-2 text-lg text-white bg-gray-800 rounded mt-5 inline-block"
                href="http://127.0.0.1:8000/blog">Start Here</a>
            -->
        </div>

        @auth
            @if(session('success'))
                <div class="bg-green-100 p-4 mb-2 rounded-md shadow-md">
                    <span class='text-green-800'> {{ session('success') }} </span>
                </div>
            @endif
            
            @if(!hasCorp()) {{--and !verify_user('SuperUser|Admin'))--}}
                <div class="bg-red-100 border border-red-400 text-center mt-5 p-5 rounded">
                    <p class="text-gray-900"><strong>You don't have any corporations yet. Please add one to take part in meetings.</strong></p>
                    <a class="px-3 py-2 text-lg text-gray-900 bg-red-400 rounded mt-5 inline-block" href="{{ route('corporationRegister') }}"><strong>LINK USER TO COTPOTATION</strong></a>
                </div>
            @endif
            
            <main class="container mx-auto px-5 flex flex-growr ">
                <div class="mb-5">
                    <h2 class="my-5 text-3xl text-yellow-500 font-bold">My Meetings</h2>
                    <div class="w-full">
                        <div class="grid grid-cols-1 gap-10 w-full md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @if(isset($meetings))
                                @foreach($meetings as $meeting)
                                    <div class="w-full">
                                        <div class="m-3 border border-black rounded-lg p-4 shadow-lg">
                                            <div class="flex items-center mb-2">
                                                <a href="#" class="text-white rounded-xl px-3 py-1 text-sm mr-3" style="background-color: {{ get_meeting_color($meeting->meeting_status_id) ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }};">
                                                    {{ get_meeting_status($meeting->meeting_status_id) }}
                                                </a>    
                                                <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('Y-m-d H:i') }}</p>
                                                <span class="text-gray-500 text-sm px-3">{{$meeting->duration}} minutes</span>
                                            </div>
                                            <h3 class="text-xl font-semibold text-gray-700 pt-4">{{$meeting->description}}</h3>
                                            <h4 class="text-lg font-semibold text-gray-700 pt-2">About</h4>
                                            <p class="text-md text-gray-600 ">{{$meeting->text}}</p>
                                            <h4 class="text-lg font-semibold text-gray-700 pt-2">Purpose</h4>
                                            <a class="text-lg text-gray-600">{{$meeting->purpose}}</a>

                                            <div class="py-2">
                                                <span class="text-md text-green-600">Meeting Ocurance : {{get_meeting_interval($meeting->meeting_interval_id)}}</span>
                                            </div>
                                            <div class="py-2">
                                                <span  class="text-md text-green-600">Location : {{get_meeting_location($meeting->meeting_location_id)}}</span>
                                            </div>

                                            @if(isset($meeting->external_url))
                                                <div class="p-2">
                                                    <a href="{{$meeting->external_url}}" class="text-lg text-gray-600">Meeting Link</a>
                                                </div>
                                            @endif

                                            <div class="flex justify-between mt-5">
                                                @if(verify_user('Organizer|Attendee'))
                                                    <a href="{{ route('meetingView', $meeting->id) }}" class="text-yellow-500 font-semibold">View</a>
                                                @endif
                                                @if(verify_user('Organizer|CorpAdmin'))    
                                                    <a href="{{ route('meetingEdit', $meeting->id) }}" class="text-yellow-500 font-semibold">Edit</a>
                                                @endif
                                            </div>    
                                        </div>
                                    </div>
                                @endforeach                                
                            @endif 
                        </div>
                    </div>
                    <div class="grid w-full text-center flex justify-center">
                        <a class="m-5 block text-center text-lg text-yellow-500 font-semibold"
                            href="{{ route('meetingList') }}">More...
                        </a>
                    </div>
                </div>
                <hr>
            </main>  
        @else
            <main class="container mx-auto px-5 flex flex-grow">
                <div class="mb-5">
                    <h2 class="mt-16 mb-5 text-center text-3xl text-yellow-500 font-bold">Please Login</h2>
                    <a class="px-3 py-2 text-lg text-white bg-gray-800 rounded mt-5 inline-block" href="{{ route('dashboard') }}">Go to Dashboard</a>
                    <hr>
                </div>
            </main>  
        @endauth
    @endsection
</x-ezim::ezimeeting>