<?php

/*
 * This file is part of the Indigo Money package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Money;

/**
 * Currency Repository
 *
 * Handles currencies making it possible to dynamically add fictional currencies
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CurrencyRepository
{
    /**
     * Currency declarations
     *
     * @var array
     */
    protected static $currencies = array();

    /**
     * Initialize currencies without validation
     *
     * @param array  $currencies
     */
    public static function initialize(array $currencies)
    {
        static::$currencies = $currencies;
    }

    public function add($code, array $definition)
    {
        
    }

    public function has($code)
    {
        return array_key_exists($code, static::$currencies);
    }
}
