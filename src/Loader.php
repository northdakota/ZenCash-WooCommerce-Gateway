<?php

namespace Zencash\Payment;

/**
 * Class Loader
 * @package Zencash
 */
class Loader
{
    const PHP_FILE_POSTFIX = '.php';

    /**
     * @var string
     */
    protected $pluginDir;

    /**
     * @var array
     */
    protected $dirMap = [
        'class' => 'src/',
        'lib'   => 'lib/',
    ];

    /**
     * @var array
     */
    protected $map = [
        'class' => [
            'Zencash\Payment\Zencash'          => 'Payment/Zencash',
            'Zencash\Payment\Currency'         => 'Payment/Currency',
            'Zencash\Payment\Helper'           => 'Payment/Helper',
            'Zencash\Payment\Strategy'         => 'Payment/Strategy',
            'Zencash\Payment\ThankYouPage'     => 'Payment/ThankYouPage',
            'Zencash\Payment\RateResolver'     => 'Payment/RateResolver',
            'Zencash\Payment\StrategyResolver' => 'Payment/StrategyResolver',
            'Zencash\Payment\Strategy\Address' => 'Payment/Strategy/Address',
            'Zencash\Payment\Strategy\Rpc'     => 'Payment/Strategy/Rpc',
        ],
        'lib'   => [
            'Hexim\HeximZcashBundle\Zcash\ZcashUtilInterface'   => 'Zcash/ZcashUtilInterface',
            'Hexim\HeximZcashBundle\Zcash\ZcashWalletInterface' => 'Zcash/ZcashWalletInterface',
            'Hexim\HeximZcashBundle\Zcash\ZcashAbstract'        => 'Zcash/ZcashAbstract',
            'Hexim\HeximZcashBundle\Zcash\ZcashUtil'            => 'Zcash/ZcashUtil',
            'Hexim\HeximZcashBundle\Zcash\ZcashWallet'          => 'Zcash/ZcashWallet',
            'Hexim\HeximZcashBundle\Zcash\ZcashWrapper'         => 'Zcash/ZcashWrapper',
        ],
    ];

    public function load()
    {
        foreach ($this->map as $mapType => $data) {
            $dir = $this->dirMap[$mapType];
            foreach ($data as $className => $filePath) {
                $filePath = $this->getPluginDir() . $dir . $filePath . self::PHP_FILE_POSTFIX;
                if (file_exists($filePath) && is_readable($filePath)) {
                    require_once $filePath;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getPluginDir()
    {
        return $this->pluginDir;
    }

    /**
     * @param string $pluginDir
     */
    public function setPluginDir($pluginDir)
    {
        $this->pluginDir = $pluginDir;
    }
}