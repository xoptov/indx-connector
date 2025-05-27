<?php

namespace Xoptov\IndxConnector\Request;

class Param
{
    private string $login;

    private string $password;

    private string $wmid;

    private string $culture;

    private string $signature;

    private int $reqn;

    private ?string $np = null;

    private $trading = null;

    private $offer = null;

    private $tick = null;

    public static function createForBalance()
    {
        
    }

    private function __construct(
        string $login, string $password, string $wmid, string $culture, string $signature, int $reqn
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->wmid = $wmid;
        $this->culture = $culture;
        $this->signature = $signature;
        $this->reqn = $reqn;
    }
}