<div>
    <div class="flex justify-between mb-4">
        <button wire:click="previousMonth">&lt;</button>
        <h2>{{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}</h2>
        <button wire:click="nextMonth">&gt;</button>
    </div>

    <div class="grid grid-cols-7 gap-2">
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="font-bold">{{ $day }}</div>
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
                $dailyMeetings = $meetings->filter(fn($meeting) => $meeting->date->format('Y-m-d') === $date);
            @endphp

            <div class="border p-2">
                <strong>{{ $day }}</strong>
                @foreach($dailyMeetings as $meeting)
                    <div class="text-sm mt-1">
                        📅 {{ $meeting->title }}
                        <ul class="text-xs ml-3 list-disc">
                            @foreach($meeting->minutes as $minute)
                                <li>{{ \Illuminate\Support\Str::limit($minute->content, 30) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endfor
    </div>
</div>