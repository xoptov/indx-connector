<?php

namespace Xoptov\IndxConnector\Credential;

class Credential
{
    private string $login;

    private string $password;

    private string $wmid;

    public function __construct(string $login, string $password, string $wmid)
    {
        $this->login = $login;
        $this->password = $password;
        $this->wmid = $wmid;
    }

    public function login(): string
    {
        return $this->login;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function wmid(): string
    {
        return $this->wmid;
    }
}