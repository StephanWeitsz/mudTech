<div class="mx-5 p-10 bg-gray-200">

    @include('ezimeeting::livewire.includes.heading.ezi-full-heading')

    <div class="flex bg-gray-400 justify-between mb-4">
        <button wire:click="previousMonth">&lt;</button>
        <h2 class="font-bold">{{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}</h2>
        <button wire:click="nextMonth">&gt;</button>
    </div>
   
    <div class="grid grid-cols-7 gap-2">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="font-bold bg-blue-400">{{ $day }}</div>
        @endforeach

        @php
            $startDay = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
            $padding = $startDay->dayOfWeek;
        @endphp

        @for($i = 0; $i < $padding; $i++)
            <div></div>
        @endfor

        @for($day = 1; $day <= $startDay->daysInMonth; $day++)
            @php
                $date = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                $dailyMeetings = $meetings->filter(fn($meeting) => $meeting->scheduled_at->format('Y-m-d') === $date);
            @endphp

            <div class="border p-2 bg-blue-200">
                <strong>{{ $day }}</strong>
                @foreach($dailyMeetings as $meeting)
                    @php
                        $bgColorClass = $meeting->meetingStatus?->color ?? 'bg-gray-50';
                    @endphp
                    <a href="{{ route('meetingView', $meeting) }}">
                        <div class="text-sm mt-1 p-2 rounded" style="background-color: {{ $bgColorClass ?? '#f0f0f0' }}">
                            📅 {{ \Illuminate\Support\Str::limit($meeting->description, 50, '...') }}
                            {{--
                            <span class="ml-2 font-semibold text-blue-500">
                                [{{ $minute->state ?? 'No State' }}]
                            </span>
                            --}}
                        </div>
                    </a>
                @endforeach
            </div>
        @endfor
    </div>
</div>