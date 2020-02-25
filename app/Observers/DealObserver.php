<?php

namespace App\Observers;

use App\DealDay;

class DealObserver
{
    public function creating(DealDay $dealDay)
    {
        if (!isset($dealDay->profit)) {
            $dealDay->profit = $this->skinProfit($dealDay->leather) + $this->withoutSkinProfit($dealDay->wleather);
        }

        if ($dealDay->dayOff == 1) {
            $dealDay->profit *= 2;
        }
    }

    function skinProfit($kg)
    {
        $profit = 0;
        if (($kg > 0) && ($kg <= 35)) {
            $profit = $kg * 17.5;
        }
        if (($kg > 35) && ($kg <= 70)) {
            $profit = 35 * 17.5 + ($kg - 35) * 18.5;
        }
        if (($kg > 70) && ($kg <= 100)) {
            $profit = 35 * 17.5 + 35 * 18.5 + ($kg - 70) * 19;
        }
        if ($kg > 100) {
            $profit = 35 * 17.5 + 35 * 18.5 + 30 * 19 + ($kg - 100) * 20;
        }
        return $profit;
    }

    function withoutSkinProfit($kg)
    {
        $profit = 0;
        if (($kg > 0) && ($kg <= 35)) {
            $profit = $kg * 21.5;
        }
        if (($kg > 35) && ($kg <= 70)) {
            $profit = 35 * 21.5 + ($kg - 35) * 23;
        }
        if (($kg > 70) && ($kg <= 100)) {
            $profit = 35 * 21.5 + 35 * 23 + ($kg - 70) * 23.5;
        }
        if ($kg > 100) {
            $profit = 35 * 21.5 + 35 * 23 + 30 * 23.5 + ($kg - 100) * 25;
        }
        return $profit;
    }

}
