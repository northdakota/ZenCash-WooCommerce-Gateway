<?php

namespace Zencash\Payment;

/**
 * Class Zencash
 * @package Zencash\Payment
 */
class Zencash extends \WC_Payment_Gateway
{
    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var bool
     */
    private $rpc;

    /**
     * @var string
     */
    private $rpc_host;

    /**
     * @var string
     */
    private $rpc_user;

    /**
     * @var string
     */
    private $rpc_password;

    /**
     * ZenCash_Gateway constructor.
     */
    public function __construct()
    {
        $this->id                 = 'zencash_gateway';
        $this->method_title       = __('ZenCash GateWay', 'zencash_gateway');
        $this->method_description = __('ZenCash Payment Gateway Plug-in for WooCommerce. You can find more information about this payment gateway on our website. You\'ll need a daemon online for your address.',
            'zencash_gateway');
        $this->title              = __('ZenCash Gateway', 'zencash_gateway');
        $this->version            = '1.0';

        $this->icon       = apply_filters('woocommerce_offline_icon', '');
        $this->has_fields = false;

        $this->rpc          = $this->get_option('rpc');
        $this->rpc_host     = $this->get_option('rpc_host');
        $this->rpc_user     = $this->get_option('rpc_user');
        $this->rpc_password = $this->get_option('rpc_password');

        if (is_admin()) {
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
            add_filter('woocommerce_currencies', ['Zencash\Payment\Currency', 'addCurrency']);
            add_filter('woocommerce_currency_symbol', ['Zencash\Payment\Currency', 'addSymbol'], 10, 2);
            add_action('woocommerce_email_before_order_table', [$this, 'email_instructions'], 10, 2);
        }

        ThankYouPage::$settings = $this->settings;
        add_action('woocommerce_thankyou_' . $this->id, [new ThankYouPage, 'instruction']);

        add_action('woocommerce_add_order_item_meta', [$this, 'addExchangeRate'], 1, 2);

        $this->init_settings();
        $this->init_form_fields();
    }

    /**
     * Initialize Gateway Settings Form Fields
     */
    public function init_form_fields()
    {
        $this->form_fields = apply_filters('wc_zencash_gateway_form_fields', [

            'enabled' => [
                'title'   => __('Enable/Disable', 'wc-zencash-gateway'),
                'type'    => 'checkbox',
                'label'   => __('Enable ZenCash payment method', 'wc-zencash-gateway'),
                'default' => 'no',
            ],

            'title' => [
                'title'       => __('Title', 'wc-zencash-gateway'),
                'type'        => 'text',
                'description' => __('This controls the title for the payment method the customer sees during checkout.',
                    'wc-zencash-gateway'),
                'default'     => __('ZenCash payment', 'wc-zencash-gateway'),
                'desc_tip'    => true,
            ],

            'description' => [
                'title'       => __('Description', 'wc-zencash-gateway'),
                'type'        => 'textarea',
                'description' => __('Payment method description that the customer will see on your checkout.',
                    'wc-zencash-gateway'),
                'default'     => __('', 'wc-zencash-gateway'),
                'desc_tip'    => true,
            ],

            'zencash_address' => [
                'title'    => __('ZenCash Address', 'wc-zencash-gateway'),
                'label'    => __('Useful for people that have not a daemon online'),
                'type'     => 'text',
                'desc_tip' => __('Zencash Wallet Address', 'wc-zencash-gateway'),
            ],

            'rpc' => [
                'title'   => __('Enable/Disable', 'wc-zencash-gateway'),
                'type'    => 'checkbox',
                'label'   => __('Use zen rpc client (Not implemented yet!)', 'wc-zencash-gateway'),
                'default' => 'no',
            ],

            'rpc_host' => [
                'title'   => __('RPC Host', 'wc-zencash-gateway'),
                'label'   => __('Host of where zen daemon is installed'),
                'type'    => 'text',
                'default' => __('127.0.0.1:18231', 'wc-zencash-gateway'),
            ],

            'rpc_user' => [
                'title' => __('RPC User', 'wc-zencash-gateway'),
                'label' => __('RPC User to access zen daemon'),
                'type'  => 'text',
            ],

            'rpc_password' => [
                'title'   => __('RPC Password', 'wc-zencash-gateway'),
                'label'   => __('RPC Password to access zen daemon'),
                'type'    => 'text',
                'default' => __('', 'wc-zencash-gateway'),
            ],

        ]);
    }

    /**
     * @return bool|void
     */
    public function validate_fields()
    {
        $helper = new Helper();
        if ($this->rpc == 'no') {
            if ($helper->validateAddress($this->address) != true) {
                echo "<div class=\"error\"><p>Your ZenCash Address doesn't look valid. Have you checked it?</p></div>";
            }
        }
    }


    public function process_payment($orderId)
    {
        $order = wc_get_order($orderId);
        $order->update_status('on-hold', __('Awaiting offline payment', 'wc-zencash-gateway'));

        wc_reduce_stock_levels($orderId);

        WC()->cart->empty_cart();

        return [
            'result'   => 'success',
            'redirect' => $this->get_return_url($order),
        ];

    }

    /**
     * @param $itemId
     * @param $values
     */
    public function addExchangeRate($itemId, $values)
    {
        $currency = get_woocommerce_currency();

        if ($currency == Helper::ZEN_CURRENCY) {
            return;
        }

        if (empty($values['zen_exchange_rate'])) {
            $rateResolver = new RateResolver();
            $rate         = $rateResolver->getRate();
            wc_add_order_item_meta($itemId, 'zen_exchange_rate', $rate);
        }
    }
}