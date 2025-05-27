<?php

namespace Xoptov\IndxConnector\Request;

use DateTimeInterface;

class Tick
{
    private int $toolId;

    private DateTimeInterface $dateStart;

    private DateTimeInterface $dateEnd;

    public function __construct(int $toolId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd)
    {
        $this->toolId = $toolId;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function params(): array
    {
        return [
            'ID' => $this->toolId,
            'DateStart' => $this->dateStart->format('Ymd'),
            'DateEnd' => $this->dateEnd->format('Ymd')
        ];
    }
}