<?php

namespace Zencash\Payment\Strategy;

use Zencash\Payment\Strategy;

/**
 * Class Address
 * @package Zencash\Payment\Strategy
 */
class Address extends Strategy
{

    const BASE_API_URL = 'https://explorer.zensystem.io/insight-api-zen/';
    const TX_LIST_URL = 'addr/';
    const TX_VIEW_URL = 'tx/';

    /**
     * @param $amount
     *
     * @return bool
     */
    public function isConfirmed($amount)
    {
        $http = new \WP_Http;

        $requestResult = $http->get(
            self::BASE_API_URL . self::TX_LIST_URL . $this->settings['zencash_address'],
            ['sslverify' => false]
        );

        $transactionsResponse = json_decode($requestResult['body']);

        $txs = $transactionsResponse->transactions;

        $i = 0;
        foreach ($txs as $tx) {
            $http = new \WP_Http;

            usleep(200000);

            $requestResult = $http->get(
                self::BASE_API_URL . self::TX_VIEW_URL . $tx,
                ['sslverify' => false]
            );

            $result = json_decode($requestResult['body']);
            foreach ($result->vout as $vout) {
                if (
                    $vout->scriptPubKey->addresses[0] == $this->settings['zencash_address'] &&
                    round($vout->value, 4) == $amount
                ) {
                    return true;
                }
            }

            // Check only last 10 transactions
            if ($i >= 10) {
                break;
            }

            $i++;
        }

        return false;
    }
}