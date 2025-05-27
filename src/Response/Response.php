<?php

namespace Xoptov\IndxConnector\Response;

class Response
{
    const STATUS_OK = 0;

    const STATUS_ERROR = 1;

    const STATUS_REJECT = 2;

    private int $status;

    private ?int $code;

    private ?string $desc;

    private ?object $payload;

    public function __construct(
        int $status, ?int $code = null, ?string $desc = null, ?object $payload = null
    ) {
        $this->status = $status;
        $this->code = $code;
        $this->desc = $desc;
        $this->payload = $payload;
    }

    public function isOk(): bool
    {
        return self::STATUS_OK === $this->status;
    }

    public function isError(): bool
    {
        return self::STATUS_ERROR === $this->status;
    }

    public function isReject(): bool
    {
        return self::STATUS_REJECT === $this->status;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getDesc(): ?string
    {
        return $this->desc;
    }

    public function getPayload(): ?object
    {
        return $this->payload;
    }
}