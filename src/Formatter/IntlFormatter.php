<?php

/*
 * This file is part of the Indigo Money package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Formatter;

use Indigo\Money\Money;
use NumberFormatter;

/**
 * Formatter using PHP built-in NumberFormatter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class IntlFormatter implements FormatterInterface
{
    /**
     * NumberFormatter object
     *
     * @var NumberFormatter
     */
    protected $numberFormatter;

    /**
     * Creates a new IntlFormatter
     *
     * @param string|NumberFormatter $arg
     */
    public function __construct($arg)
    {
        if (is_string($arg)) {
            $arg = new NumberFormatter($arg, NumberFormatter::CURRENCY);
        }

        if (!$arg instanceof NumberFormatter) {
            throw new \InvalidArgumentException('Either a string or a NumberFormatter should be passed.');
        }

        $this->numberFormatter = $arg;
    }
    /**
     * {@inheritdoc}
     */
    public function format(Money $money)
    {
        $currency = $money->getCurrency();

        return $this->numberFormatter->formatCurrency(
            $money->getAmount() / $currency->getSubUnit(),
            $currency->getCode()
        );
    }
}
