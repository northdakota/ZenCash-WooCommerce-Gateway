<?php

namespace Zencash\Payment;

/**
 * Class StrategyResolver
 * @package Zencash\Payment
 */
class StrategyResolver
{

    const STRATEGY_CLASS_PREFIX = 'Zencash\\Payment\\Strategy\\';

    /**
     * @var array
     */
    protected static $map = [
        false => 'Address',
        true  => 'Rpc',
    ];

    /**
     * @param $isRpc bool
     *
     * @return Strategy
     */
    public static function getStrategy($isRpc)
    {
        $className = self::STRATEGY_CLASS_PREFIX . self::$map[$isRpc];

        return new $className;
    }
}
