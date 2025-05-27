<?php

namespace Xoptov\IndxConnector\Url;

class BaseUrl
{
    const DEFAULT_SCHEMA = 'https';

    private ?string $schema;

    private string $host;

    private ?int $port;

    private string $path;

    public function __construct(
        string $host, string $path, ?string $schema = null, ?int $port = null
    ) {
        $this->host = $host;
        $this->path = $path;
        $this->schema = $schema;
        $this->port = $port;
    }

    public function __toString(): string
    {
        if ($this->schema) {
            $url = $this->schema;
        } else {
            $url = self::DEFAULT_SCHEMA;
        }
        $url .= '://'.$this->host;
        if ($this->port) {
            $url .= ':'.$this->port;
        }
        $url .= $this->path;
        return $url;
    }
}