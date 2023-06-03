<?php

namespace Custura\Trane\Actions\Trane;

use App\Models\Team;
use Custura\Trane\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Team $team): void
    {
        $team->purge();
    }
}
