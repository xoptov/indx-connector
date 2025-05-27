<?php

namespace Xoptov\INDXConntector\INDXConnector;

use CurlHandle;
use DateTimeInterface;
use Xoptov\IndxConnector\Request\Param;
use Xoptov\IndxConnector\Result\Balance\Result as BalanceResult;

class INDXConnector {

    static private ?self $instance = null;

    private int $requestNumber = 0;

    private string $login;

    private string $password;

    private string $wmid;

    private string $culture = 'en-EN';

    private int $lastRequestAt = 0;

    private $ch;

    public static function create(
        string $host, string $path, string $login, string $password, string $wmid, array $options
    ): self {
        if (static::$instance) {
            return static::$instance;
        }
        return new self($host, $path, $login, $password, $wmid, $options);
    }

    public function balance(): BalanceResult
    {
        return new BalanceResult;
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

    public function __destruct()
    {
        curl_close($this->ch);
    }

    private function __construct(
        string $host, string $path, string $login, string $password, string $wmid, array $options
    ) {
        //todo: need implement constractor
    }
}