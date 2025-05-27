<?php

namespace Xoptov\IndxConnector;

use CurlHandle;
use DateTimeInterface;
use Xoptov\IndxConnector\Url\BaseUrl;
use Xoptov\IndxConnector\Response\Response;
use Xoptov\IndxConnector\Credential\Credential;

class IndxConnector
{
    const DEFAULT_CULTURE = 'en-EN';

    static private ?self $instance = null;

    private BaseUrl $baseUrl;

    private Credential $credential;

    private array $options = [];

    private int $requestNumber = 0;

    private int $lastRequestAt = 0;

    private ?CurlHandle $ch = null;

    public static function create(
        BaseUrl $baseUrl, Credential $credential, array $options
    ): self {
        if (static::$instance) {
            return static::$instance;
        }
        return new self($baseUrl, $credential, $options);
    }

    public function balance()
    {
    }

    public function tools()
    {
    }

    public function np()
    {
    }

    public function exTools()
    {
    }

    public function exToolsByNp(string $np)
    {
    }

    public function historyTrading(int $tradeId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd)
    {
    }

    public function historyTransaction(int $tradeId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd)
    {
    }

    public function offerMy()
    {
    }

    public function offerList(int $assetId)
    {
    }

    public function offerAdd(int $assetId, bool $isBid, float $quantity, float $price)
    {
    }

    public function offerDelete(int $offerId)
    {
    }

    public function tick(int $assetId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd)
    {
    }

    public function canMakeRequest(): bool
    {
        return time() - $this->lastRequestAt > 1;
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    private function __construct(
        BaseUrl $baseUrl, Credential $credential, array $options
    ) {
        $this->baseUrl = $baseUrl;
        $this->credential = $credential;
        $this->options = $options;
    }

    private function makeRequest(): Response
    {
        //todo: тут будет делаться запрос к хосту и накручиваться счётчик.
        return new Response(Response::STATUS_OK);
    }

    private function updateRequestNumber(): void
    {
        $this->requestNumber++;
    }

    private function updateLastRequestAt(): void
    {
        $this->lastRequestAt = time();
    }
}