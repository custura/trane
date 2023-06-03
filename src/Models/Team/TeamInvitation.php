<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Custura\Trane\Trane;
use Custura\Trane\TeamInvitation as TraneTeamInvitation;

class TeamInvitation extends TraneTeamInvitation
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Trane::teamModel());
    }
}
