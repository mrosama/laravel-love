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

namespace Cog\Laravel\Love\Reactant\ReactionSummary\Services;

use Cog\Contracts\Love\Reactant\Models\Reactant as ReactantContract;
use Cog\Contracts\Love\Reactant\ReactionSummary\Exceptions\ReactionSummaryBadValue;
use Cog\Contracts\Love\Reactant\ReactionSummary\Exceptions\ReactionSummaryMissing;
use Cog\Contracts\Love\Reactant\ReactionSummary\Models\ReactionSummary as ReactionSummaryContract;
use Cog\Contracts\Love\Reaction\Models\Reaction as ReactionContract;
use Cog\Laravel\Love\Reactant\ReactionSummary\Models\NullReactionSummary;

final class ReactionSummaryService
{
    private $reactant;

    private $reactionSummary;

    public function __construct(ReactantContract $reactant)
    {
        $this->reactant = $reactant;
        $this->reactionSummary = $this->findReactionSummaryFor($reactant);
    }

    public function addReaction(ReactionContract $reaction): void
    {
        $this->incrementTotalCount();
        $this->incrementTotalWeight($reaction->getWeight());
    }

    public function removeReaction(ReactionContract $reaction): void
    {
        $this->decrementTotalCount();
        $this->decrementTotalWeight($reaction->getWeight());
    }

    private function incrementTotalCount(int $amount = 1): void
    {
        $this->incrementOrDecrementTotalCount($amount);
    }

    private function decrementTotalCount(int $amount = 1): void
    {
        $amount *= -1;
        $this->incrementOrDecrementTotalCount($amount);
    }

    private function incrementTotalWeight(int $amount = 1): void
    {
        $this->incrementOrDecrementTotalWeight($amount);
    }

    private function decrementTotalWeight(int $amount = 1): void
    {
        $amount *= -1;
        $this->incrementOrDecrementTotalWeight($amount);
    }

    private function incrementOrDecrementTotalCount(int $amount = 1): void
    {
        if ($this->reactionSummary->getTotalCount() + $amount < 0) {
            throw ReactionSummaryBadValue::totalCountBelowZero();
        }

        $this->reactionSummary->increment('total_count', $amount);
    }

    private function incrementOrDecrementTotalWeight(int $amount = 1): void
    {
        $this->reactionSummary->increment('total_weight', $amount);
    }

    private function findReactionSummaryFor(ReactantContract $reactant): ReactionSummaryContract
    {
        /** @var \Cog\Laravel\Love\Reactant\ReactionSummary\Models\ReactionSummary $summary */
        $summary = $reactant->getReactionSummary();

        if ($summary instanceof NullReactionSummary) {
            throw ReactionSummaryMissing::forReactant($reactant);
        }

        return $summary;
    }
}
