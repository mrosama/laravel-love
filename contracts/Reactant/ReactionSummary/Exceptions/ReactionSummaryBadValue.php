<?php

/*
 * This file is part of Laravel Love.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Contracts\Love\Reactant\ReactionSummary\Exceptions;

use UnexpectedValueException;

final class ReactionSummaryBadValue extends UnexpectedValueException
{
    public static function totalCountBelowZero(): self
    {
        return new static('ReactionSummary `total_count` could not be below zero.');
    }
}
