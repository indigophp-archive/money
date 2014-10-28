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
 * Money Value Object
 *
 * Implements Fowler's Money pattern
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class Money
{
	/**
	 * Amount
	 *
	 * @var integer
	 */
	private $amount;

	/**
	 * Currency object
	 *
	 * @var Currency
	 */
	private $currency;

    private static $roundingModes = array(
        PHP_ROUND_HALF_UP,
        PHP_ROUND_HALF_DOWN,
        PHP_ROUND_HALF_EVEN,
        PHP_ROUND_HALF_ODD,
    );

	/**
	 * Creates a new Money object
	 *
	 * @param integer  $amount
	 * @param string|Currency $currency
	 */
	public function __construct($amount, $currency)
	{
        $this->assertInteger($amount);

		$this->amount = $amount;
        $this->currency = $currency;
	}

    /**
     * Returns a new Money
     *
     * @param string $currency
     * @param array  $arguments
     *
     * @return Money
     */
    public function __callStatic($currency, $arguments)
    {
        return new Money($arguments[0], $currency);
    }

    /**
     * Returns a new Money instance
     *
     * @param integer $amount
     *
     * @return Money
     */
    private function newInstance($amount)
    {
        return new Money($amount, $this->currency);
    }

    /**
     * Returns the amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns the Currency
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Returns a new Money object that represents
     * the sum of this and an other Money object
     *
     * @param Money $money
     *
     * @return Money
     */
    public function add(Money $money)
    {
        $this->assertSameCurrency($money);

        $amount = $this->amount + $money->getAmount();

        $this->assertInteger($amount);

        return $this->newInstance($amount);
    }

    /**
     * Returns a new Money object that represents
     * the difference of this and an other Money object
     *
     * @param Money $money
     *
     * @return Money
     */
    public function subtract(Money $money)
    {
        $this->assertSameCurrency($money);

        $amount = $this->amount - $money->getAmount();

        $this->assertInteger($amount);

        return $this->newInstance($amount);
    }

    /**
     * Returns a new Money object that represents
     * the multiplied value by the given factor
     *
     * @param numeric $factor
     * @param integer $roundingMode
     *
     * @return Money
     */
    public function multiply($factor, $roundingMode = PHP_ROUND_HALF_UP)
    {
        $this->assertRoundingMode($roundingMode);

        $amount = $this->castToInteger($this->amount * $factor, 0, $roundingMode);

        return $this->newInstance($amount);
    }

    public function allocateByRatios($ratios)
    {
        // This method can be used without array params
        if (!is_array($ratios)) {
            $ratios = func_get_args();
        }

        $result = array();
        $total = array_sum($ratios);
        $remainder = $this->amount;

        foreach ($ratios as $ratio) {
            $amount = $this->castToInteger($this->amount * $ratio / $total);
            $result[] = $this->newInstance($amount);
            $remainder -= $amount;
        }

        for ($i=0; $i < $remainder; $i++) {
            $result[$i] = $this->newInstance($result[$i]->getAmount() + 1);
        }

        return $result;
    }

    /**
     * Returns a new Money object that represents
     * the negated value of this object
     *
     * @return Money
     */
    public function negate()
    {
        return $this->newInstance(-1 * $this->amount);
    }

    /**
     * Checks whether the value equals to zero
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->amount === 0;
    }

    /**
     * Checks whether the value is greater then zero
     *
     * @return boolean
     */
    public function isPositive()
    {
        return $this->amount > 0;
    }

    /**
     * Checks whether the value is less then zero
     *
     * @return boolean
     */
    public function isNegative()
    {
        return $this->amount < 0;
    }

    /**
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this object is considered to be respectively
     * less than, equal to, or greater than the other
     *
     * @param Money $value
     *
     * @return integer -1|0|1
     */
    public function compareTo(Money $money)
    {
        $this->assertSameCurrency($money);

        $amount = $money->getAmount();

        switch (true) {
            case $this->amount === $amount:
                return 0;
                break;
            case $this->amount > $amount:
                return 1;
                break;
            case $this->amount < $amount:
                return -1;
                break;
        }
    }


    /**
     * Checks whether the value represented by this object equals to the other
     *
     * @param Money $value
     *
     * @return boolean
     */
    public function equals(Money $value)
    {
        return $this->compareTo($value) === 0;
    }

    /**
     * Checks whether the value represented by this object does not equal to the other
     *
     * @param Money $value
     *
     * @return boolean
     */
    public function notEquals(Money $value)
    {
        return $this->compareTo($value) !== 0;
    }

    /**
     * Checks whether the value represented by this object is greater than the other
     *
     * @param Money $value
     *
     * @return boolean
     */
    public function greaterThan(Money $value)
    {
        return $this->compareTo($value) === 1;
    }

    /**
     * Checks whether the value represented by this object is greater than or equals the other
     *
     * @param Money $value
     *
     * @return boolean
     */
    public function greaterThanOrEqual(Money $value)
    {
        return $this->compareTo($value) >= 0;
    }

    /**
     * Checks whether the value represented by this object is less than the other
     *
     * @param Money $value
     *
     * @return boolean
     */
    public function lessThan(Money $value)
    {
        return $this->compareTo($value) === -1;
    }

    /**
     * Checks whether the value represented by this object is less than or equals the other
     *
     * @param Money $value
     *
     * @return boolean
     */
    public function lessThanOrEqual(Money $value)
    {
        return $this->compareTo($value) <= 0;
    }

    /**
     * Checks whether a Money has the same Currency as this
     *
     * @param Currency $currency
     *
     * @return boolean
     */
    public function isSameCurrency(Money $money)
    {
        $currency = $money->getCurrency();

        return $this->currency->isSame($currency);
    }

    /**
     * Asserts that a Money has the same currency as this
     *
     * @param Money $Money
     */
    private function assertSameCurrency(Money $money)
    {
        $currency = $money->getCurrency();

        $this->currency->assertSame($currency);
    }

    private function handleCurrency($currency)
    {
        if (is_string($currency)) {
            $currency = new Currency($currency);
        }

        return $currency;
    }

    /**
     * Asserts that rounding mode is valid
     *
     * @param integer $roundingMode
     */
    private function assertRoundingMode($roundingMode)
    {
        if (!in_array($roundingMode, self::$roundingModes)) {
            throw new \InvalidArgumentException('Rounding mode should be one of PHP_ROUND_HALF_*.');
        }
    }

    /**
     * Asserts that a numeric value is between integer bounds
     *
     * @param integer $amount
     *
     * @throws OverflowException  If $amount is greater than PHP_INT_MAX
     * @throws UnderflowException If $amount is less than ~PHP_INT_MAX
     */
    private function assertIntegerBounds($amount)
    {
        if ($amount > PHP_INT_MAX) {
            throw new \OverflowException;
        } elseif ($amount < ~PHP_INT_MAX) {
            throw new \UnderflowException;
        }
    }

    /**
     * Asserts that amount is integer
     *
     * @param integer $amount
     *
     * @throws UnexpectedValueException If $amount is not integer
     */
    private function assertInteger($amount)
    {
        if (!is_int($amount)) {
            throw new \UnexpectedValueException('Amount is expected to be integer.');
        }
    }

    /**
     * Casts a numeric value to integer
     *
     * @param numeric $amount
     *
     * @return integer
     */
    private function castToInteger($amount)
    {
        $this->assertIntegerBounds($amount);

        return intval($amount);
    }
}
