<?php

namespace Mudtec\Ezimeeting\Livewire\Meeting;

use Livewire\Component;
use Carbon\Carbon;

use Mudtec\Ezimeeting\Models\Meeting;

class CalendarMeetings extends Component
{
    public $currentMonth;
    public $currentYear;

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

        return view('livewire.calendar-meetings', [
            'meetings' => $meetings,
            'startOfMonth' => $start,
        ]);
    }
}
