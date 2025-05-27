<?php

namespace Xoptov\IndxConnector\Request;

use Xoptov\IndxConnector\Credential\Credential;

class Request
{
    private string $path;

    private Credential $credential;

    private string $culture;

    private string $signature;

    private int $reqn;

    private ?string $np = null;

    private ?Trading $trading = null;

    private ?Offer $offer = null;

    private ?Tick $tick = null;

    private function __construct(
        string $path, Credential $credential, string $culture, string $signature, int $reqn
    ) {
        $this->path = $path;
        $this->credential = $credential;
        $this->culture = $culture;
        $this->signature = $signature;
        $this->reqn = $reqn;
    }

    public function setNP(string $np): void
    {
        $this->np = $np;
    }

    public function setTrading(Trading $trading): void
    {
        $this->trading = $trading;
    }

    public function setOffer(Offer $offer): void
    {
        $this->offer = $offer;
    }

    public function setTick(Tick $tick): void
    {
        $this->tick = $tick;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function params(): array
    {
        $params = [
            'ApiContext' => [
                'Login' => $this->credential->login(),
                'Wmid' => $this->credential->wmid(),
                'Culture' => $this->culture,
                'Signature' => $this->signature,
                'Reqn' => $this->reqn,
            ]
        ];
        if ($this->np) {
            $params['NP'] = $this->np;
        }
        if ($this->trading) {
            $params['Trading'] = $this->trading->params();
        }
        if ($this->offer) {
            $params['Offer'] = $this->offer->params();
        }
        return $params;
    }
}