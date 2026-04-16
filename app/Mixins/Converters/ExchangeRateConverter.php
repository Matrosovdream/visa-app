<?php
namespace App\Mixins\Converters;

use GuzzleHttp\Client;

class ExchangeRateConverter
{
    protected $apiUrl;
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiUrl = 'https://v6.exchangerate-api.com/v6/';
        $this->apiKey = env('EXCHANGE_RATE_API_KEY');
        $this->client = new Client();
    }

    public function convert(string $fromCurrency, string $toCurrency, float $amount): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        if (empty($this->apiKey)) {
            return $amount;
        }

        $url = $this->apiUrl . $this->apiKey . '/latest/' . $fromCurrency;

        $response = $this->client->get($url);
        $data = $this->processResponse($response);

        $rate = $data['conversion_rates'][$toCurrency];
        return $amount * $rate;
    }

    protected function processResponse($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
