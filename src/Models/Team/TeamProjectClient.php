<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Custura\Trane\Team as TraneTeam;
use App\Models\Team;
use Custura\Trane\Models\Team\TeamProjectClientBind;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamProjectClient extends TraneTeam
{
    use HasFactory;

    protected $table = 'team_clients';

    protected $fillable = [
        'id',
        'team_id',
        'client_name',
        'client_adress',
        'projects',
        'status',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function projectClients(): HasMany
    {
        return $this->hasMany(TeamProjectClientBind::class, 'project_id', 'id');
    }
}
