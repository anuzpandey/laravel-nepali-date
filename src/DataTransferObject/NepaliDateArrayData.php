<?php

namespace Anuzpandey\LaravelNepaliDate\DataTransferObject;

class NepaliDateArrayData
{
    public function __construct(
        public readonly string $year,
        public readonly string $month,
        public readonly string $day,
        public readonly string $npYear,
        public readonly string $npMonth,
        public readonly string $npDay,
        public readonly string $dayName,
        public readonly string $monthName,
        public readonly string $npDayName,
        public readonly string $npMonthName,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['year'],
            $data['month'],
            $data['day'],
            $data['npYear'],
            $data['npMonth'],
            $data['npDay'],
            $data['dayName'],
            $data['monthName'],
            $data['npDayName'],
            $data['npMonthName'],
        );
    }

    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'npYear' => $this->npYear,
            'npMonth' => $this->npMonth,
            'npDay' => $this->npDay,
            'dayName' => $this->dayName,
            'monthName' => $this->monthName,
            'npDayName' => $this->npDayName,
            'npMonthName' => $this->npMonthName,
        ];
    }
}
