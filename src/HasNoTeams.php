<?php

namespace Custura\Trane;

trait HasNoTeams
{
    /**
     * Determine if the user is apart of any team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function isMemberOfATeam(): bool
    {
        return (bool) ($this->teams()->count() || $this->ownedTeams()->count());
    }
}
