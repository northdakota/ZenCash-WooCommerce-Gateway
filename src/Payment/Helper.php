<?php

namespace Zencash\Payment;

/**
 * Class Helper
 * @package Zencash\Payment
 */
class Helper
{
    const ZEN_CURRENCY = 'ZEN';
    const ZEN_NAME = 'ZenCash';
    const ZEN_RATE_CACHE_KEY = 'zen_exchange_rate';

    /**
     * @param $address string
     *
     * @return bool
     */
    public function validateAddress($address)
    {
        if (strlen($address) !== 35) {
            return false;
        }

        if (strpos($address, 'zn') !== 0) {
            return false;
        }

        if ( ! preg_match('/[0-9A-Za-z]/', $address)) {
            return false;
        }

        return true;

    }
}