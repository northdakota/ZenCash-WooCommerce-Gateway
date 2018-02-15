<?php
/*
Plugin Name: ZenCash Gateway
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Extends WooCommerce by Adding the ZenCash Gateway
Author: Vladimir Polischuk (NorthDakota)
Version: 1.0
Author URI: https://zenblog.info
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Make sure WooCommerce is active
if ( ! in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

add_action('plugins_loaded', 'wc_zencash_gateway_init', 11);

function wc_zencash_gateway_init()
{
    $pluginDir = plugin_dir_path(__FILE__);
    include_once 'src/Loader.php';
    $loader = new \Zencash\Payment\Loader();
    $loader->setPluginDir($pluginDir);
    $loader->load();
}

function wc_offline_add_to_gateways($gateways)
{
    $gateways[] = 'Zencash\Payment\Zencash';

    return $gateways;
}

add_filter('woocommerce_payment_gateways', 'wc_offline_add_to_gateways');