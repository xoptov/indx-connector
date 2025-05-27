<?php

namespace Xoptov\IndxConnector\Signer;

class Signer
{
    public function sign(array $data): string
    {
        return hash('sha256', base64_encode(implode(';', $data)));
    }
}