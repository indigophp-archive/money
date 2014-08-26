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
    use \Indigo\Comparison\AssertSameTrait;
    use \Indigo\Comparison\SameTrait;

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
     * Alias to getCode()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCode();
    }
}
