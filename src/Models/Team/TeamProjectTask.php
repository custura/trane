<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Custura\Trane\Team as TraneTeam;
use App\Models\Team;
use Custura\Trane\Models\Team\TeamProjectTaskBind;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamProjectTask extends TraneTeam
{
    use HasFactory;

    protected $table = 'team_project_tasks';

    protected $fillable = [
        'id',
        'title',
        'description',
        'team_id',
        'status',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function projectTasks(): HasMany
    {
        return $this->hasMany(TeamProjectTaskBind::class, 'project_id', 'id');
    }
}
