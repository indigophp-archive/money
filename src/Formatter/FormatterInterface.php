<?php

/*
 * This file is part of the Indigo Money package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Money\Formatter;

use Indigo\Money\Money;

/**
 * Formatter Interface
 *
 * Implement this to be able to format Money objects
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface FormatterInterface
{
    /**
     * Formats a Money object value
     *
     * @param Money $money
     *
     * @return mixed
     */
    public function format(Money $money);
}
