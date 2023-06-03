<?php

namespace Custura\Trane\Models\Team;

use Custura\Trane\CanBeTransferred;
use Custura\Trane\Team as TraneTeam;
use Custura\Trane\Events\TeamCreated;
use Custura\Trane\Events\TeamDeleted;
use Custura\Trane\Events\TeamUpdated;
use Custura\Trane\Models\Team\TeamRole;
use Custura\Trane\Models\Team\TeamRolePermission;
use Custura\Trane\Models\Team\TeamSetting;
use Custura\Trane\Models\Team\TeamProject;
use Custura\Trane\Models\Team\TeamProjectTask;
use Custura\Trane\Models\Team\TeamProjectClient;
use Custura\Trane\Models\Team\TeamProjectTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends TraneTeam
{
    use HasFactory;
    use CanBeTransferred;

    protected $table = 'teams';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    
    public function settings(): HasOne
    {
        return $this->hasOne(TeamSetting::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(TeamProject::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(TeamProjectClient::class);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(TeamProjectTemplate::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(TeamProjectTask::class);
    }

    // These are the roles specific to a team that can be edited.
    // Excluding those predefined by the server administrator.
    public function editableTeamRoles(): HasMany
    {
        return $this->hasMany(TeamRole::class);
    }

    // These are all available roles that can be assigned to a team member.
    // Including those predefined by the server administrator.
    public function teamAvailableRoles(): HasMany
    {
        return $this->hasMany(TeamRole::class)->orWhereNull('team_roles.team_id')->orderBy('team_id', 'desc');
    }

    public function defaultTeamRoles(): HasMany
    {
        return $this->hasMany(TeamRole::class)->whereNull('team_roles.team_id');
    }

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(teamRolePermission::class);
    }
}
