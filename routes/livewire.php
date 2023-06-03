<?php

use Illuminate\Support\Facades\Route;
use Custura\Trane\Http\Controllers\CurrentTeamController;
use Custura\Trane\Http\Controllers\Livewire\ApiTokenController;
use Custura\Trane\Http\Controllers\Livewire\PrivacyPolicyController;
use Custura\Trane\Http\Controllers\Livewire\TeamController;
use Custura\Trane\Http\Controllers\Livewire\TermsOfServiceController;
use Custura\Trane\Http\Controllers\Livewire\UserProfileController;
use Custura\Trane\Http\Controllers\TeamInvitationController;
use Custura\Trane\Http\Controllers\PrivatAppointmentController;
use Custura\Trane\Http\Controllers\TeamHelperController;
use Custura\Trane\Http\Controllers\UsersController;
use Custura\Trane\Trane;

Route::group(['middleware' => config('trane.middleware', ['web'])], function () {
    if (Trane::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    $authMiddleware = config('trane.guard')
        ? 'auth:'.config('trane.guard')
        : 'auth';

    $authSessionMiddleware = config('trane.auth_session', false)
        ? config('trane.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
        // Dashboard administration zone // todo: rework
        Route::resource('users', UsersController::class);
        
        // User & Profile & appointments...
        Route::get('/user/show/profile', function () { return view('profile.show'); })->name('profile.show');
        Route::get('/user/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::resource('appointments', PrivatAppointmentController::class);
        Route::group(['middleware' => 'verified'], function () {
            // API...
            if (Trane::hasApiFeatures()) {
                Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            }

            // Teams...
            if (Trane::hasTeamFeatures()) {
                //TODO: de facut protectie daca nu are auth()->user()->current_team_id aici sau in appointmentscalendar
                Route::get('/calendar', function () { return view('appointment.team.calendar'); })->name('calendar');
                
                Route::get('/teams/{team}/show/projects', [TeamHelperController::class, 'index'])->name('teams.project.show-project');
                Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
                Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');

                Route::resource('projects', TeamHelperController::class);

                Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                    ->middleware(['signed'])
                    ->name('team-invitations.accept');
            }
        });
    });
});
