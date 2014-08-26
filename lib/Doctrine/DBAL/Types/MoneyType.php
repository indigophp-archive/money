<?php

/*
 * This file is part of the Indigo Money package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doctrine\DBAL\Types;

use Indigo\Money\Currency;
use Indigo\Money\Money;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Money Type
 *
 * Uses Fowler's money pattern implemented by Sebastioan Bergmann
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class MoneyType extends IntegerType
{
    /**
     * Default currency
     *
     * @var string
     */
    protected static $defaultCurrency;

    /**
     * Currency
     *
     * International currency symbol
     *
     * @var string
     */
    protected $currency;

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getAmount();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Money((int) $value, new Currency($this->getCurrency()));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'money';
    }

    /**
     * Returns the currency
     *
     * @return string
     */
    public function getCurrency()
    {
        if ($this->currency === null)
        {
            $this->setCurrency(self::getDefaultCurrency());
        }

        return $this->currency;
    }

    /**
     * Sets the currency
     *
     * @param string $currency
     *
     * @return this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Returns the default currency
     *
     * @return string
     */
    protected static function getDefaultCurrency()
    {
        // If no default currency is specified
        if (static::$defaultCurrency === null)
        {
            // detect from locale
            $localeconv = localeconv();

            static::setDefaultCurrency($localeconv['int_curr_symbol']);
        }

        return static::$defaultCurrency;
    }

    /**
     * Sets the default currency
     *
     * @param string $currency
     */
    public static function setDefaultCurrency($currency)
    {
        static::$defaultCurrency = $currency;
    }
}
