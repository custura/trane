<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Custura\Trane\Team as TraneTeam;
use App\Models\Team;
use Custura\Trane\Models\Team\TeamProjectTemplateBind;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamProjectTemplate extends TraneTeam
{
    use HasFactory;

    protected $table = 'team_project_templates';

    protected $fillable = [
        'id',
        'team_id',
        'title',
        'description',
        'content',
        'status',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function projectTemplates(): HasMany
    {
        return $this->hasMany(TeamProjectTemplateBind::class, 'template_id', 'id');
    }
}
