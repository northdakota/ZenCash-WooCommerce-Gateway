<?php

namespace Zencash\Payment;

/**
 * Class Strategy
 * @package Zencash
 */
abstract class Strategy
{
    protected $settings = [];

    /**
     * @param $data array
     */
    public function setSettings(array $data)
    {
        $this->settings = $data;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param $amount
     *
     * @return bool
     */
    public function isConfirmed($amount){}
}