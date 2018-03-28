<?php

namespace Xoptov\INDXConnector\Request;

use JsonSerializable;

class OfferMy extends AbstractRequest implements JsonSerializable
{
    /** @var string */
    protected $url = "https://api.indx.ru/api/v2/trade/OfferMy";

    /** @var string */
    protected $method = "POST";

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $parts = [
            $this->credential->getLogin(),
            $this->credential->getPassword(),
            $this->culture,
            $this->credential->getWmid()
        ];

        $signature = implode(';', $parts);

        $data = [
            "ApiContext" => [
                "Login" => $this->credential->getLogin(),
                "Password" => $this->credential->getPassword(),
                "Wmid" => $this->credential->getWmid(),
                "Culture" => $this->culture,
                "Signature" => $this->credential->encodeSignature($signature)
            ]
        ];

        return $data;
    }
}