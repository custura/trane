<?php

namespace Custura\Trane\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Custura\Trane\Actions\ValidateTeamDeletion;
use Custura\Trane\Contracts\DeletesTeams;
use Custura\Trane\RedirectsActions;
use Livewire\Component;

class DeleteTeamForm extends Component
{
    use RedirectsActions;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * Indicates if team deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingTeamDeletion = false;

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    /**
     * Delete the team.
     *
     * @param  \Custura\Trane\Actions\ValidateTeamDeletion  $validator
     * @param  \Custura\Trane\Contracts\DeletesTeams  $deleter
     * @return void
     */
    public function deleteTeam(ValidateTeamDeletion $validator, DeletesTeams $deleter)
    {
        $validator->validate(Auth::user(), $this->team);

        $deleter->delete($this->team);

        return $this->redirectPath($deleter);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.delete-team-form');
    }
}
