<?php

namespace Xoptov\IndxConnector\Request;

use DateTimeInterface;

class Trading
{
    private int $assetId;

    private DateTimeInterface $dateStart;

    private DateTimeInterface $dateEnd;

    public function __construct(int $assetId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd)
    {
        $this->assetId = $assetId;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function getParams(): array
    {
        return [
            'ID' => $this->assetId,
            'DateStart' => $this->dateStart->format('c'),
            'DateEnd' => $this->dateEnd->format('c'),
        ];
    }
}