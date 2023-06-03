<?php

namespace Custura\Trane\Models\User;

use Custura\Trane\HasNoTeams;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Custura\Trane\HasProfilePhoto;
use Custura\Trane\HasTeams;
use Custura\Trane\Models\Team\TeamProject;
use Custura\Trane\Models\Team\TeamRole;
use Laravel\Sanctum\HasApiTokens;
use Custura\Trane\Models\User\Appointment as PrivatAppointment;
use Custura\Trane\Models\User\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use HasNoTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'gender',
        'country',
        'town',
        'birthday',
        'homepage',
        'about',
        'userdescription',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function teamRoles(): BelongsToMany
    {
        return $this->belongsToMany(TeamRole::class);
    }

    public function privatAppointments(): HasMany
    {
    	return $this->hasMany(PrivatAppointment::class);
    }
}
