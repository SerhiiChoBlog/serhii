<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use DateTime;

class AboutMeController extends Controller
{
    public function index(): View
    {
        $diff = $this->getDateDiff();
        return view('about-me', compact('diff'));
    }

    private function getDateDiff(): string
    {
        $started_career = date_create('2017-05-24');
        $current_date = new DateTime();

        $result = date_diff($started_career, $current_date);

        if ($result->m === 0) {
            return $result->format("%y years");
        }

        return $result->format("%y years %m months");
    }
}
