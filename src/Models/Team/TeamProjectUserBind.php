<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Custura\Trane\Models\Team\TeamProject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamProjectUserBind extends Model
{
    use HasFactory;

    protected $table = 'team_project_user_binds';

    protected $fillable = [
        'id',
        'user_id',
        'team_id',
        'project_id',
        'rate',
        'status',
    ];

    public function teamProjects(): BelongsTo
    {
        return $this->belongsTo(TeamProject::class,'project_id', 'id');
    }
}

