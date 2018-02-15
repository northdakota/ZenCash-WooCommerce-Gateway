<?php

namespace Zencash\Payment;

/**
 * Class Currency
 * @package Zencash\Payment
 */
class Currency
{
    /**
     * @param $currencies
     *
     * @return mixed
     */
    public function addCurrency($currencies)
    {
        $currencies[Helper::ZEN_CURRENCY] = __(Helper::ZEN_NAME, 'woocommerce');

        return $currencies;
    }

    /**
     * @param $currency_symbol
     * @param $currency
     *
     * @return string
     */
    function addSymbol($currency_symbol, $currency)
    {
        switch ($currency) {
            case Helper::ZEN_CURRENCY:
                $currency_symbol = Helper::ZEN_CURRENCY;
                break;
        }

        return $currency_symbol;
    }
}