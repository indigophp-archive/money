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
 * Currencies
 *
 * Contains a list of currencies
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Currencies
{
    /**
     * Currency definitions
     *
     * @var array
     */
    protected $currencies = array();

    /**
     * Initialize currencies without validation
     *
     * @param array $currencies
     */
    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }

    public function add($code, array $definition)
    {
        
    }

    /**
     * Deletes a currency
     *
     * @param string $code
     *
     * @return boolean
     */
    public function delete($code)
    {
        if ($this->has($code)) {
            unset($this->currencies[$code]);

            return true;
        }

        return false;
    }

    public function has($code)
    {
        return array_key_exists($code, $this->currencies);
    }
}
