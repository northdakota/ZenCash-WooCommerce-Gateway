<?php

namespace Zencash\Payment\Strategy;

use Hexim\HeximZcashBundle\Zcash\ZcashWrapper;
use Zencash\Payment\Strategy;

/**
 * Class Rpc
 * @package Zencash\Payment\Strategy
 */
class Rpc extends Strategy
{
    /**
     * @param $amount
     *
     * @return bool|void
     * @throws \Exception
     */
    public function isConfirmed($amount)
    {
        $settings = $this->getSettings();
        $wallet   = new ZcashWrapper([
            'rpc_address'  => $settings['rpc_host'],
            'rpc_user'     => $settings['rpc_user'],
            'rpc_password' => $settings['rpc_password'],
        ]);

        $command = [
            'jsonrpc' => '1.0',
            'id'      => 'curl',
            'method'  => 'listtransactions',
            'params'  => [
                $this->settings['zencash_address'],
            ],
        ];

        $result = $wallet->rpcZcashCommand($command);

        $t = 1;
    }
}