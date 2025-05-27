<?php

namespace Xoptov\IndxConnector;

use CurlHandle;
use DateTimeInterface;
use Xoptov\IndxConnector\Url\BaseUrl;
use Xoptov\IndxConnector\Request\Tick;
use Xoptov\IndxConnector\Signer\Signer;
use Xoptov\IndxConnector\Request\Offer;
use Xoptov\IndxConnector\Request\Trading;
use Xoptov\IndxConnector\Request\Request;
use Xoptov\IndxConnector\Response\Result;
use Xoptov\IndxConnector\Credential\Credential;

class IndxConnector
{
    const DEFAULT_CULTURE = 'en-EN';

    static private ?self $instance = null;

    private Signer $signer;

    private BaseUrl $baseUrl;

    private Credential $credential;

    private array $options;

    private int $requestNumber = 0;

    private int $lastRequestAt = 0;

    private ?CurlHandle $ch = null;

    public static function create(
        Signer $signer, BaseUrl $baseUrl, Credential $credential, ?array $options = []
    ): self {
        if (static::$instance) {
            return static::$instance;
        }
        return new self($signer, $baseUrl, $credential, $options);
    }

    public function balance(): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/Balance', $reqn, [$this->wmid(), $reqn]);
        return $this->send($request);
    }

    public function tools(): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/Tools', $reqn, [$reqn]);
        return $this->send($request);
    }

    public function np(): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/NP', $reqn, [$reqn]);
        return $this->send($request);
    }

    public function exTools(): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/ExTools', $reqn, [$reqn]);
        return $this->send($request);
    }

    public function exToolsByNp(string $np): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/ExToolsByNP', $reqn, [$this->wmid(), $np, $reqn]);
        $request->setNP($np);
        return $this->send($request);
    }

    public function historyTrading(
        int $toolId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd
    ): Result {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest(
            '/HistoryTrading', $reqn,
            [$this->wmid(), $toolId, $dateStart->format('Ymd'), $dateEnd->format('Ymd'), $reqn]
        );
        $request->setTrading(new Trading($toolId, $dateStart, $dateEnd));
        return $this->send($request);
    }

    public function historyTransaction(
        int $toolId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd
    ): Result {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest(
            '/HistoryTransaction', $reqn,
            [$this->wmid(), $toolId, $dateStart->format('Ymd'), $dateEnd->format('Ymd'), $reqn]
        );
        $request->setTrading(new Trading($toolId, $dateStart, $dateEnd));
        return $this->send($request);
    }

    public function offerMy(): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/OfferMy', $reqn, [$this->wmid(), $reqn]);
        return $this->send($request);
    }

    public function offerList(int $toolId): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/OfferList', $reqn, [$this->wmid(), $toolId, $reqn]);
        $request->setOffer(Offer::createForList($toolId));
        return $this->send($request);
    }

    public function offerAdd(
        int $toolId, bool $bid, float $notes, float $price
    ): Result {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest(
            '/OfferAdd', $reqn, [$this->wmid(), $toolId, $bid, $notes, $price, $reqn]
        );
        $request->setOffer(Offer::createForAdd($toolId, $bid, $notes, $price));
        return $this->send($request);
    }

    public function offerDelete(int $offerId): Result
    {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest('/OfferDelete', $reqn, [$this->wmid(), $offerId, $reqn]);
        $request->setOffer(Offer::createForDelete($offerId));
        return $this->send($request);
    }

    public function tick(
        int $toolId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd
    ): Result {
        $reqn = $this->requestNumber();
        $request = $this->makeRequest(
            '/Tick', $reqn, 
            [$this->wmid(), $toolId, $dateStart->format('Ymd'), $dateEnd->format('Ymd'), $reqn]
        );
        $request->setTick(new Tick($toolId, $dateStart, $dateEnd));
        return $this->send($request);
    }

    public function canMakeRequest(): bool
    {
        return time() - $this->lastRequestAt > 1;
    }

    public function requestNumber(): int
    {
        return $this->requestNumber++;
    }

    public function culture(): string
    {
        if (!empty($this->options['culture'])) {
            return $this->options['culture'];
        }
        return self::DEFAULT_CULTURE;
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    private function __construct(
        Signer $signer, BaseUrl $baseUrl, Credential $credential, ?array $options
    ) {
        $this->signer = $signer;
        $this->baseUrl = $baseUrl;
        $this->credential = $credential;
        $this->options = $options;
    }

    private function makeRequest(string $path, int $reqn, array $extSingData): Request
    {
        return new Request(
            $path, $this->credential, $this->culture(), $this->sign($extSingData), $reqn
        );
    }

    private function send(Request $request): Result
    {
        //todo: Need implement send request to INDX api server.
    }

    private function updateLastRequestAt(): void
    {
        $this->lastRequestAt = time();
    }

    private function login(): string
    {
        return $this->credential->login();
    }

    private function password(): string
    {
        return $this->credential->password();
    }

    private function wmid(): string
    {
        return $this->credential->wmid();
    }

    private function sign(array $extData): string
    {
        return $this->signer->sign(
            array_merge($this->basicSignData(), $extData)
        );
    }

    private function basicSignData(): array
    {
        return [
            'Login' => $this->login(),
            'Password' => $this->password(),
            'Culture' => $this->culture()
        ];
    }
}