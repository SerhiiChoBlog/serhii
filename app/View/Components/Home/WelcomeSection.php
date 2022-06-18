<?php

namespace App\View\Components\Home;

use DateInterval;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WelcomeSection extends Component
{
    private DateInterval $date_diff;

    public function __construct()
    {
        $this->date_diff = $this->getDateDiff();
    }

    public function render(): View
    {
        return view('components.home.welcome-section');
    }

    public function yearsExperience(): string
    {
        $months = (int) $this->date_diff->format('%m');
        $years = (int) $this->date_diff->format('%y');

        if (in_array($months, [4, 5, 6, 7], true)) {
            return "$years and a half";
        }

        if (in_array($months, [8, 9, 10], true)) {
            ++$years;
            return "almost $years";
        }

        if (in_array($months, [11, 12], true)) {
            ++$years;
        }

        return (string) $years;
    }

    public function fullExperience(): string
    {
        return $this->date_diff->format("%y years %m months");
    }

    private function getDateDiff(): DateInterval
    {
        $started_career = date_create('2017-05-24');
        $current_date = new DateTime();

        return date_diff($started_career, $current_date);
    }
}
