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

namespace Cog\Laravel\Love\Reaction\Models;

use Cog\Contracts\Love\Reactant\Models\Reactant as ReactantContract;
use Cog\Contracts\Love\Reacter\Models\Reacter as ReacterContract;
use Cog\Contracts\Love\Reaction\Models\Reaction as ReactionContract;
use Cog\Contracts\Love\ReactionType\Models\ReactionType as ReactionTypeContract;
use Cog\Laravel\Love\Reactant\Models\Reactant;
use Cog\Laravel\Love\Reacter\Models\Reacter;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Reaction extends Model implements ReactionContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'love_reactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reaction_type_id',
        'reactant_id',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ReactionType::class, 'reaction_type_id');
    }

    public function reactant(): BelongsTo
    {
        return $this->belongsTo(Reactant::class, 'reactant_id');
    }

    public function reacter(): BelongsTo
    {
        return $this->belongsTo(Reacter::class, 'reacter_id');
    }

    public function getType(): ReactionTypeContract
    {
        // TODO: What if ReactionType not found? Maybe return `NullReactionType`?
        return $this->getAttribute('type');
    }

    public function getReactant(): ReactantContract
    {
        // TODO: What if Reactant not found? Maybe return `NullReactant`?
        return $this->getAttribute('reactant');
    }

    public function getReacter(): ReacterContract
    {
        // TODO: What if Reacter not found? Maybe return `NullReacter`?
        return $this->getAttribute('reacter');
    }

    public function getWeight(): int
    {
        return $this->getType()->getWeight();
    }
}
