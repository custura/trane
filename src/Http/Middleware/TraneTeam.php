<?php

namespace Custura\Trane\Http\Middleware;

use Closure;
use Custura\Trane\Trane;
use Illuminate\Support\Facades\Auth;
use Custura\Trane\Models\Team\TeamRole;

class TraneTeam
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        /**
        * Configure the Team roles and permissions that are available within the application.
        */
        if ($user && $user->currentTeam) {
            foreach (TeamRole::with('team')->where('team_id', Auth::user()->currentTeam->id)->orWhereNull('team_id')->get() as $role) {
                Trane::role($role->key, $role->name,
                    explode(',', $role->permissions)
                )->description($role->description);
            }
        }

        return $next($request);
    }
}
