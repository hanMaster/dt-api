<?php

namespace App\Observers;

use App\FixedDay;

class FixedObserver
{
    public function creating(FixedDay $fixedDay)
    {
        if ($fixedDay->dayOff == 1) {
            $fixedDay->profit *= 2;
        }
    }
}
