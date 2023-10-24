<?php

namespace Anuzpandey\LaravelNepaliDate\Traits;

trait DiffForHumsTrait
{
    public function nepaliDiffForHumans($diffInHuman): string
    {
        $expData = explode(' ', $diffInHuman);

        $numberData = $expData[0];

        $index = strpos($diffInHuman, $expData[0]) + strlen($expData[0]);
        $remainingData = substr($diffInHuman, $index);

        return $this->convertEnToNpNumber($numberData).$this->convertEnToNpWord($remainingData);
    }
}
