<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting\Calendar;

use Livewire\Component;
use Carbon\Carbon;

use Mudtec\Ezimeeting\Models\Meeting;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;

    public $page_heading = 'Meeting Calandar';
    public $page_sub_heading = 'View Scheduled Meetings';

    public function mount()
    {
        $now = Carbon::now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function render()
    {
        $start = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $meetings = Meeting::with('minutes')
            ->whereBetween('date', [$start, $end])
            ->get();

            $meetings = Meeting::with('minutes')
    ->whereHas('minutes', function ($query) use ($start, $end) {
        $query->whereBetween('date', [$start, $end]);
    })
    ->get();

        //dd($start,$end,$meetings);    

        return view('ezimeeting::livewire.meeting.calendar.calender', [
            'meetings' => $meetings,
            'startOfMonth' => $start,
        ]);
    }
}
