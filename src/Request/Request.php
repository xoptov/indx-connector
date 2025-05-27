<?php

namespace Xoptov\IndxConnector\Request;

use Xoptov\IndxConnector\Credential\Credential;

class Request
{
    private Credential $credential;

    private string $culture;

    private string $signature;

    private int $reqn;

    private ?string $np = null;

    private ?Trading $trading = null;

    private ?Offer $offer = null;

    private ?Tick $tick = null;

    public static function createBalance(
        Credential $credential, string $culture, string $signature, int $reqn
    ): Request {
        return new Request($credential, $culture, $signature, $reqn);
    }

    private function __construct(
        Credential $credential, string $culture, string $signature, int $reqn
    ) {
        $this->credential = $credential;
        $this->culture = $culture;
        $this->signature = $signature;
        $this->reqn = $reqn;
    }

    public function getParams(): array
    {
        $body = [
            'ApiContext' => [
                'Login' => $this->credential->getLogin(),
                'Wmid' => $this->credential->getWmid(),
                'Culture' => $this->culture,
                'Signature' => $this->signature,
                'Reqn' => $this->reqn,
            ]
        ];
        if ($this->np) {
            $body['NP'] = $this->np;
        }
        if ($this->trading) {
            $body['Trading'] = $this->trading->getParams();
        }
        return $body;
    }
}