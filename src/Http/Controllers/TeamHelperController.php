<?php

namespace Custura\Trane\Http\Controllers;

use Custura\Trane\Models\Team\TeamProject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Custura\Trane\Trane;
use Custura\Trane\Http\Requests\UpdateTeamProjectRequest;
use Custura\Trane\Http\Requests\StoreTeamProjectRequest;

class TeamHelperController extends Controller
{
    /**
     * Show the team management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $teamId)
    {
        $team = Trane::newTeamModel()->findOrFail($teamId);

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        if (auth()->user()->current_team_id == $teamId)
        {
            $projects = $team->projects();

            return view('teams.project.index', [
                'user' => $request->user(),
                'team' => $team,
            ], compact('projects'));
        }
        else {
            return redirect()->route('teams.project.show-project', auth()->user()->current_team_id)->banner(
                __('Ups! Is not part of your team.'),
            );
        }
    }

    /**
     * Show the team creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create()
    {
        Gate::authorize('create', Trane::newTeamModel());

        return view('teams.project.create');
    }

    public function store(StoreTeamProjectRequest $request)
    {
        Gate::authorize('create', Trane::newTeamModel());

    	$project = new TeamProject();
    	$project->description = $request->description;
        $project->title = $request->title;
        $project->team_id = auth()->user()->current_team_id;
    	$project->save();

        return redirect()->route('projects.show', $project->id)->banner(
            __('Great! Your project has successfully created.'),
        );
    }

    public function show(TeamProject $project)
    {
        Gate::authorize('create', Trane::newTeamModel());

        if (auth()->user()->current_team_id == $project->team_id)
        {
            return view('teams.project.show', compact('project'));
        }
        else {
            return redirect()->route('teams.project.show-project', auth()->user()->current_team_id)->banner(
                __('Ups! Is not part of your team.'),
            );
        }
    }

    public function edit(TeamProject $project)
    {
        Gate::authorize('create', Trane::newTeamModel());

        if (auth()->user()->current_team_id == $project->team_id)
        {
            $team = Trane::newTeamModel()->findOrFail($project->team_id);
            return view('teams.project.edit', [
                'team' => $team,
            ],compact('project'));
        }
        else {
            return redirect()->route('teams.project.show-project', auth()->user()->current_team_id)->banner(
                __('Ups! Is not part of your team.'),
            );
        }
    }

    public function update(UpdateTeamProjectRequest $request, TeamProject $project)
    {
        Gate::authorize('create', Trane::newTeamModel());

        $project->update($request->validated());

        return redirect()->route('teams.project.show-project', $project->team_id)->banner(
            __('Great! You have modified successfully.'),
        );
    }

    public function destroy(TeamProject $project)
    {
        Gate::authorize('create', Trane::newTeamModel());
        if (auth()->user()->current_team_id == $project->team_id)
        {
            $project->delete();

            return redirect()->route('teams.project.show-project', $project->team_id)->banner(
                __('Great! You have deleted successfully.'),
            );
        }
        else {
            return redirect()->route('teams.project.show-project', auth()->user()->current_team_id)->banner(
                __('Ups! Is not part of your team.'),
            );
        }
    }
}
