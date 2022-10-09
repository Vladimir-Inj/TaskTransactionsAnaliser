<?php

namespace App;

class CurrencyRates
{
    private static $instance;
    const URL = 'https://api.apilayer.com/exchangerates_data/latest?base=EUR';
    const API_KEY = 'zf0Igsi3tR9qSK65MaxfzuZjEiprnO82';
    private array $rates;

    private function __construct()
    {
        $rawContent = $this->runApiRequest();
        $rates = @json_decode($rawContent, true);
        if (empty($rates['rates'])) {
            throw new \Exception("Can't read rates from " . self::URL);
        }
        $this->rates = $rates['rates'];
    }

    public function unsetInstance() : void
    {
        self::$instance = null;
    }

    private function runApiRequest() : string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => self::URL,
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/plain',
                'apikey: ' . self::API_KEY,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function getInstance() : self
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getRate($currency) : float
    {
        if (empty($this->rates[$currency])) {
            throw new \Exception("There is no rate for currency {$currency}");
        }

        return $this->rates[$currency];
    }
}
