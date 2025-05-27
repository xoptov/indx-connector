<?php

namespace Xoptov\IndxConnector\Request;

class Offer
{
    private ?int $toolId = null;

    private ?bool $bid = null;

    private ?float $notes = null;

    private ?float $price = null;

    private ?int $offerId = null;

    public static function createForList(int $toolId): self
    {
        $offer = new self;
        $offer->toolId = $toolId;
        return $offer;
    }

    public static function createForAdd(int $toolId, bool $bid, float $notes, float $price): self
    {
        $offer = new self;
        $offer->toolId = $toolId;
        $offer->bid = $bid;
        $offer->notes = $notes;
        $offer->price = $price;
        return $offer;
    }

    public static function createForDelete(int $offerId): self
    {
        $offer = new self;
        $offer->offerId = $offerId;
        return $offer;
    }

    public function params(): array
    {
        $params = [];
        if ($this->toolId) {
            $params['ID'] = $this->toolId;
            if ($this->bid !== null) {
                $params['isBid'] = $this->bid;
            }
            if ($this->notes !== null) {
                $params['Notes'] = $this->notes;
            }
            if ($this->price !== null ) {
                $params['Price'] = $this->price;
            }
        } else if ($this->offerId) {
            $params['OfferID'] = $this->offerId;
        }
        return $params;
    }
}