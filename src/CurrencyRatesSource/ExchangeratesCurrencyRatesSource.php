<?php
declare(strict_types = 1);

namespace Application\CurrencyRatesSource;

use Application\Exception\CurrencyRatesException;

class ExchangeratesCurrencyRatesSource implements CurrencyRatesSourceInterface
{
    private string $url;
    private string $apiKey;
    private array $rates;

    public function __construct(string $url, string $apiKey)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;

        $this->init();
    }

    private function init(): void
    {
        $rawContent = $this->runApiRequest();
        $rates = @json_decode($rawContent, true);
        if (empty($rates['rates'])) {
            throw new CurrencyRatesException("Can't read rates from {$this->url}");
        }
        $this->rates = $rates['rates'];
    }

    private function runApiRequest(): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/plain',
                'apikey: ' . $this->apiKey,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($curl);

        if (($error = curl_error($curl))) {
            throw new CurrencyRatesException("Currency rates source returned the error: {$error}");
        }

        curl_close($curl);

        return $response;
    }

    public function getRate(string $currency): float
    {
        if (empty($this->rates[$currency])) {
            throw new CurrencyRatesException("There is no rate for currency {$currency}");
        }

        return $this->rates[$currency];
    }
}
