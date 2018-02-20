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
     * @param $orderId
     *
     * @throws \Exception
     */
    public function onOrderPlace($orderId)
    {
        $order = wc_get_order($orderId);

        if ($order->get_meta('zen_order_address')) {
            return;
        }

        $newAddress = $this->generateAddress();

        if ( ! $newAddress) {
            throw new \Exception("Internal server error");
        }

        $order->update_meta_data('zen_order_address', $newAddress);
        $order->save_meta_data();
    }

    /**
     * @param $amount
     *
     * @param $orderId
     *
     * @return bool
     * @throws \Exception
     */
    public function isConfirmed($amount, $orderId)
    {
        $order   = wc_get_order($orderId);
        $address = $order->get_meta('zen_order_address');

        $addressBalance = $this->getClient()->rpcZcashCommand(
            $this->getCommand('getreceivedbyaddress', [$address])
        );

        if ($addressBalance['result'] >= $amount) {
            return true;
        }

        return false;
    }

    /**
     * @throws \Exception
     * @return string
     */
    public function generateAddress()
    {
        $result = $this->getClient()->rpcZcashCommand(
            $this->getCommand('getnewaddress')
        );

        return $result['result'];
    }

    /**
     * @return ZcashWrapper
     */
    protected function getClient()
    {
        $settings = $this->getSettings();
        $wallet   = new ZcashWrapper([
            'rpc_address'  => $settings['rpc_host'],
            'rpc_user'     => $settings['rpc_user'],
            'rpc_password' => $settings['rpc_password'],
        ]);

        return $wallet;
    }

    /**
     * @param string $command
     * @param array $params
     *
     * @return array
     */
    protected function getCommand($command, $params = null)
    {
        $result = [
            'jsonrpc' => '1.0',
            'id'      => 'curl',
            'method'  => $command,
        ];

        if ($params) {
            $result['params'] = $params;
        }

        return $result;
    }
}