<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Custura\Trane\Models\Team\TeamProjectTask;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamProjectTaskBind extends Model
{
    use HasFactory;

    protected $table = 'team_project_task_binds';

    protected $fillable = [
        'team_id',
        'project_id',
        'task_id',
    ];

    public function teamProjectTasks(): BelongsTo
    {
        return $this->belongsTo(TeamProjectTask::class,'task_id', 'id');
    }
}

