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
    use \Indigo\Comparison\AssertComparableTrait;
    use \Indigo\Comparison\SimpleComparableTrait;

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

	/**
	 * Creates a new Money object
	 *
	 * @param integer  $amount
	 * @param string|Currency $currency
	 */
	public function __construct($amount, $currency)
	{
        if (!is_int($amount)) {
            throw new \InvalidArgumentException('Amount must be an integer.');
        }

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

    public function add(Money $money)
    {
        $this->assertSameCurrency();
    }

    /**
     * {@inheritdoc}
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
     * Checks whether a Currency is the same as actual
     *
     * @param Currency $currency
     *
     * @return boolean
     */
    public function isSameCurrency(Currency $currency)
    {
        return $this->currency->isSame($currency);
    }

    /**
     * Asserts same currencies
     *
     * @param Money $Money
     */
    public function assertSameCurrency(Money $money)
    {
        $currency = $money->getCurrency();

        $this->currency->assertSame($currency);
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

    private function handleCurrency($currency)
    {
        if (is_string($currency)) {
            $currency = new Currency($currency);
        }

        return $currency;
    }
}
