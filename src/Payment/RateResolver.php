<?php

namespace Zencash\Payment;

/**
 * Class RateResolver
 * @package Zencash\Payment
 */
class RateResolver
{
    /**
     * @return bool|mixed
     */
    public function getRate()
    {
        $rate = get_transient(Helper::ZEN_RATE_CACHE_KEY);

        if ( ! $rate) {
            $rate = $this->requestNewRates();
            $this->saveNewRate($rate);

            return $rate;
        }

        return $rate;
    }

    /**
     * @param $rate
     */
    public function saveNewRate($rate)
    {
        set_transient(Helper::ZEN_RATE_CACHE_KEY, $rate, 600);
    }

    /**
     * @return mixed
     */
    protected function requestNewRates()
    {
        $http = new \WP_Http;

        $requestResult = $http->get('https://api.coinmarketcap.com/v1/ticker/zencash/?convert=' . get_woocommerce_currency());

        $result = $requestResult['body'];

        $result = json_decode($result);
        $key    = 'price_' . strtolower(get_woocommerce_currency());
        $price  = $result[0]->$key;

        return $price;
    }
}