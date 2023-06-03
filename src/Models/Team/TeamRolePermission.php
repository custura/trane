<?php

namespace Custura\Trane\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamRolePermission extends Model
{
    use HasFactory;

    protected $table = 'team_role_permissions';

    protected $fillable = [
        'title',
    ];

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
}
