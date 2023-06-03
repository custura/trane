<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Custura\Trane\Team as TraneTeam;
use App\Models\Team;
use Custura\Trane\Models\Team\TeamProjectUserBind;
use Custura\Trane\Models\Team\TeamProjectTaskBind;
use Custura\Trane\Models\Team\TeamProjectClientBind;
use Custura\Trane\Models\Team\TeamProjectTemplateBind;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamProject extends TraneTeam
{
    use HasFactory;

    protected $table = 'team_projects';

    protected $fillable = [
        'id',
        'title',
        'description',
        'team_id',
        'pause_time_1',
        'pause_time_2',
        'pause_time_3',
        'pause_time_4',
        'work_time_1',
        'work_time_2',
        'work_time_3',
        'work_time_4',
        'tasks',
        'status',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function projectUsers(): HasMany
    {
        return $this->hasMany(TeamProjectUserBind::class, 'project_id', 'id');
    }

    public function projectTasks(): HasMany
    {
        return $this->hasMany(TeamProjectTaskBind::class, 'project_id', 'id');
    }

    public function projectClients(): HasMany
    {
        return $this->hasMany(TeamProjectClientBind::class, 'project_id', 'id');
    }

    public function projectTemplates(): HasMany
    {
        return $this->hasMany(TeamProjectTemplateBind::class, 'project_id', 'id');
    }
}
