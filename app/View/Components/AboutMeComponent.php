<?php

namespace App\View\Components;

use DateInterval;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AboutMeComponent extends Component
{
    private DateInterval $date_diff;

    public function __construct()
    {
        $this->date_diff = $this->getDateDiff();
    }

    public function yearsExperience(): int
    {
        $months = (int) $this->date_diff->format('%m');
        $years = (int) $this->date_diff->format('%y');

        if ($months >= 6) {
            ++$years;
        }

        return $years;
    }

    public function fullExperience(): string
    {
        return $this->date_diff->format("%y years %m months");
    }

    private function getDateDiff(): DateInterval
    {
        $started_career = date_create('2017-05-24');
        $current_date = date_create();

        return date_diff($started_career, $current_date);
    }

    public function render(): View
    {
        return view('components.about-me-component');
    }
}
