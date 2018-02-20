<?php

namespace Zencash\Payment;

/**
 * Class ThankYouPage
 * @package Zencash\Payment
 */
class ThankYouPage
{
    public static $settings;

    /**
     * @param $orderId
     */
    public function instruction($orderId)
    {
        $dir      = plugin_dir_path(__FILE__);
        $order    = wc_get_order($orderId);
        $zenPrice = $this->getZenPrice($order);

        self::$settings['rate'] = $zenPrice;

        $conversionRate = $zenPrice / 1;
        $amount         = round($order->get_total() / $conversionRate, 4);

        self::$settings['amount'] = $amount;

        $isRpc = self::$settings['rpc'] == 'yes' ? true : false;
        /** @var Strategy $strategy */
        $strategy = StrategyResolver::getStrategy($isRpc);
        $strategy->setSettings(self::$settings);

        if ($isRpc) {
            self::$settings['zencash_address'] = $order->get_meta('zen_order_address');
        }

        if ($strategy->isConfirmed($amount, $orderId)) {
            $order->update_status('processing', __('Payment has been received', 'is_virtual_in_cart'));
            require_once $dir . 'templates/confirmed.phtml';
        } else {
            require_once $dir . 'templates/notConfirmed.phtml';
        }
    }

    /**
     * @param \WC_Order
     *
     * @return string
     */
    protected function getZenPrice(\WC_Order $order)
    {
        if ($order->get_meta('zen_exchange_rate')) {
            return $order->get_meta('zen_exchange_rate');
        }

        return 1;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getData($key)
    {
        return self::$settings[$key];
    }
}