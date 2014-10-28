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
 * Currency
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class Currency
{
    /**
     * Currency code
     *
     * @var string
     */
    private $code;

    /**
     * Currency declaration
     *
     * @var array
     */
    private $declaration = array();

    /**
     * Creates a new Currency
     *
     * @param string $code ISO 4217 currency code
     */
    public function __construct($code)
    {
        if (false) {
            throw new \InvalidArgumentException();
        }

        $this->code = $code;
    }

    /**
     * Returns the ISO 4217 currency code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the declaration of currency
     *
     * @return array
     */
    public function getDeclaration()
    {
        return $this->declaration;
    }

    /**
     * Returns the sub unit
     *
     * @return integer
     */
    public function getSubUnit()
    {
        return $this->declaration['sub_unit'];
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->declaration['name'];
    }

    /**
     * Checks if this object should be considered to be the same as the other
     *
     * @param Currency $currency
     *
     * @return boolean
     */
    public function isSame(Currency $currency)
    {
        return $this->code === $currency->getCode();
    }

    /**
     * Asserts that the other object is the same as this
     *
     * @param Currency $currency
     *
     * @throws AssertionFailedException If assertion fails
     */
    public function assertSame(Currency $currency)
    {
        if (!$this->isSame($currency)) {
            throw new \InvalidArgumentException('Failed asserting that the two values are the same.');
        }
    }

    /**
     * Alias to getCode()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCode();
    }
}
