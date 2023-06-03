<?php

namespace Custura\Trane;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Fortify\Fortify;
use Custura\Trane\Http\Livewire\ApiTokenManager;
use Custura\Trane\Http\Livewire\AppointmentsCalendar;
use Custura\Trane\Http\Livewire\CreateTeamForm;
use Custura\Trane\Http\Livewire\DeleteTeamForm;
use Custura\Trane\Http\Livewire\DeleteUserForm;
use Custura\Trane\Http\Livewire\LogoutOtherBrowserSessionsForm;
use Custura\Trane\Http\Livewire\NavigationMenu;
use Custura\Trane\Http\Livewire\TeamMemberManager;
use Custura\Trane\Http\Livewire\TwoFactorAuthenticationForm;
use Custura\Trane\Http\Livewire\UpdatePasswordForm;
use Custura\Trane\Http\Livewire\UpdateProfileInformationForm;
use Custura\Trane\Http\Livewire\UpdateTeamNameForm;
use Custura\Trane\Http\Livewire\TeamTransferForm;
use Custura\Trane\Http\Livewire\ManageTeamSetting;
use Livewire\Livewire;

class TraneServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/trane.php', 'trane');

        $this->app->afterResolving(BladeCompiler::class, function () {
            if (config('trane.stack') === 'livewire' && class_exists(Livewire::class)) {
                Livewire::component('navigation-menu', NavigationMenu::class);
                Livewire::component('profile.update-profile-information-form', UpdateProfileInformationForm::class);
                Livewire::component('profile.update-password-form', UpdatePasswordForm::class);
                Livewire::component('profile.two-factor-authentication-form', TwoFactorAuthenticationForm::class);
                Livewire::component('profile.logout-other-browser-sessions-form', LogoutOtherBrowserSessionsForm::class);
                Livewire::component('profile.delete-user-form', DeleteUserForm::class);

                if (Features::hasApiFeatures()) {
                    Livewire::component('api.api-token-manager', ApiTokenManager::class);
                }

                if (Features::hasTeamFeatures()) {
                    Livewire::component('teams.create-team-form', CreateTeamForm::class);
                    Livewire::component('teams.update-team-name-form', UpdateTeamNameForm::class);
                    Livewire::component('teams.team-member-manager', TeamMemberManager::class);
                    Livewire::component('teams.delete-team-form', DeleteTeamForm::class);
                    Livewire::component('teams.team-transfer-form', TeamTransferForm::class);
                    Livewire::component('teams.manage-team-settings', ManageTeamSetting::class);
                    Livewire::component('appointments-calendar', AppointmentsCalendar::class);
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::viewPrefix('auth.');

        $this->configurePublishing();
        $this->configureRoutes();
        $this->configureCommands();

        RedirectResponse::macro('banner', function ($message) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->with('flash', [
                'bannerStyle' => 'success',
                'banner' => $message,
            ]);
        });

        RedirectResponse::macro('dangerBanner', function ($message) {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->with('flash', [
                'bannerStyle' => 'danger',
                'banner' => $message,
            ]);
        });
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../stubs/config/trane.php' => config_path('trane.php'),
        ], 'trane-config');

        $this->publishes([
            __DIR__.'/../database/migrations/2014_10_12_000000_create_users_table.php' => database_path('migrations/2014_10_12_000000_create_users_table.php'),
            __DIR__.'/../database/migrations/2020_05_21_100000_create_teams_table.php' => database_path('migrations/2020_05_21_100000_create_teams_table.php'),
            __DIR__.'/../database/migrations/2020_05_21_200000_create_team_user_table.php' => database_path('migrations/2020_05_21_200000_create_team_user_table.php'),
            __DIR__.'/../database/migrations/2020_05_21_300000_create_team_invitations_table.php' => database_path('migrations/2020_05_21_300000_create_team_invitations_table.php'),

            __DIR__.'/../database/migrations/2023_01_12_000001_create_privat_appointments_table.php' => database_path('migrations/2023_01_12_000001_create_privat_appointments_table.php'),
            __DIR__.'/../database/migrations/2023_01_12_000002_create_roles_table.php' => database_path('migrations/2023_01_12_000002_create_roles_table.php'),
            __DIR__.'/../database/migrations/2023_01_12_000003_create_permissions_table.php' => database_path('migrations/2023_01_12_000003_create_permissions_table.php'),
            __DIR__.'/../database/migrations/2023_01_12_000004_create_permission_role_pivot_table.php' => database_path('migrations/2023_01_12_000004_create_permission_role_pivot_table.php'),
            __DIR__.'/../database/migrations/2023_01_12_000005_create_role_user_pivot_table.php' => database_path('migrations/2023_01_12_000005_create_role_user_pivot_table.php'),
           
            __DIR__.'/../database/migrations/2023_01_12_100001_create_team_settings_table.php' => database_path('migrations/2023_01_12_100001_create_team_settings_table.php'),
            __DIR__.'/../database/migrations/2023_02_12_171541_create_team_appointments_table.php' => database_path('migrations/2023_02_12_171541_create_team_appointments_table.php'),
            __DIR__.'/../database/migrations/2023_02_12_200000_create_team_clients_table.php' => database_path('migrations/2023_02_12_200000_create_team_clients_table.php'),
            __DIR__.'/../database/migrations/2023_02_12_361648_create_team_projects_table.php' => database_path('migrations/2023_02_12_361648_create_team_projects_table.php'),
            __DIR__.'/../database/migrations/2023_02_12_361649_create_team_project_user_binds_pivot_table.php' => database_path('migrations/2023_02_12_361649_create_team_project_user_binds_pivot_table.php'),
            __DIR__.'/../database/migrations/2023_02_12_361657_create_team_project_tasks_table.php' => database_path('migrations/2023_02_12_361657_create_team_project_tasks_table.php'),
            __DIR__.'/../database/migrations/2023_02_12_361658_create_team_project_task_binds_pivot_table.php' => database_path('migrations/2023_02_12_361658_create_team_project_task_binds_pivot_table.php'),
            __DIR__.'/../database/migrations/2023_02_13_161650_create_team_project_templates_table.php' => database_path('migrations/2023_02_13_161650_create_team_project_templates_table.php'),
            __DIR__.'/../database/migrations/2023_02_13_161658_create_team_project_template_binds_pivot_table.php' => database_path('migrations/2023_02_13_161658_create_team_project_template_binds_pivot_table.php'),
            __DIR__.'/../database/migrations/2023_02_13_361657_create_team_project_client_binds_pivot_table.php' => database_path('migrations/2023_02_13_361657_create_team_project_client_binds_pivot_table.php'),
            __DIR__.'/../database/migrations/2023_02_15_050007_create_team_role_permissions_table.php' => database_path('migrations/2023_02_15_050007_create_team_role_permissions_table.php'),
            __DIR__.'/../database/migrations/2023_02_15_050007_create_team_roles_table.php' => database_path('migrations/2023_02_15_050007_create_team_roles_table.php'),
        ], 'trane-migrations');

        $this->publishes([
            __DIR__.'/../routes/'.config('trane.stack').'.php' => base_path('routes/trane.php'),
        ], 'trane-routes');
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        if (Trane::$registersRoutes) {
            Route::group([
                'namespace' => 'Custura\Trane\Http\Controllers',
                'domain' => config('trane.domain', null),
                'prefix' => config('trane.prefix', config('trane.path')),
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/'.config('trane.stack').'.php');
            });
        }
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }
}
