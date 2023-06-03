<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Custura\Trane\Models\Team\TeamProjectClient;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamProjectClientBind extends Model
{
    use HasFactory;

    protected $table = 'team_project_client_binds';

    protected $fillable = [
        'team_id',
        'project_id',
        'client_id',
    ];

    public function teamProjectClients(): BelongsTo
    {
        return $this->belongsTo(TeamProjectClient::class,'client_id', 'id');
    }
}

