<?php

namespace Custura\Trane\Providers;

use App\Actions\Trane\AddTeamMember;
use App\Actions\Trane\CreateTeam;
use App\Actions\Trane\DeleteTeam;
use App\Actions\Trane\DeleteUser;
use App\Actions\Trane\InviteTeamMember;
use App\Actions\Trane\RemoveTeamMember;
use App\Actions\Trane\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Custura\Trane\Trane;

class TraneServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Trane::createTeamsUsing(CreateTeam::class);
        Trane::updateTeamNamesUsing(UpdateTeamName::class);
        Trane::addTeamMembersUsing(AddTeamMember::class);
        Trane::inviteTeamMembersUsing(InviteTeamMember::class);
        Trane::removeTeamMembersUsing(RemoveTeamMember::class);
        Trane::deleteTeamsUsing(DeleteTeam::class);
        Trane::deleteUsersUsing(DeleteUser::class);
    }
    
    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Trane::defaultApiTokenPermissions(['read']);
    }
}
