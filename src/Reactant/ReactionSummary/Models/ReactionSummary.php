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

namespace Cog\Laravel\Love\Reactant\ReactionSummary\Models;

use Cog\Contracts\Love\Reactant\Models\Reactant as ReactantContract;
use Cog\Contracts\Love\Reactant\ReactionSummary\Models\ReactionSummary as ReactionSummaryContract;
use Cog\Laravel\Love\Reactant\Models\Reactant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ReactionSummary extends Model implements ReactionSummaryContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'love_reactant_reaction_summaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_count',
        'total_weight',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total_count' => 'integer',
        'total_weight' => 'integer',
    ];

    public function reactant(): BelongsTo
    {
        return $this->belongsTo(Reactant::class, 'reactant_id');
    }

    public function getReactant(): ReactantContract
    {
        return $this->getAttribute('reactant');
    }

    public function getTotalCount(): int
    {
        return $this->getAttribute('total_count') ?? 0;
    }

    public function getTotalWeight(): int
    {
        return $this->getAttribute('total_weight') ?? 0;
    }
}
