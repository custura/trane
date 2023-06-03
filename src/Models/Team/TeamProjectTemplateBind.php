<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Custura\Trane\Models\Team\TeamProjectTemplate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamProjectTemplateBind extends Model
{
    use HasFactory;

    protected $table = 'team_project_template_binds';

    protected $fillable = [
        'team_id',
        'project_id',
        'template_id',
    ];

    public function teamProjectTemplates(): BelongsTo
    {
        return $this->belongsTo(TeamProjectTemplate::class,'template_id', 'id');
    }
}

