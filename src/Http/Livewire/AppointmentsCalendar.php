<?php

namespace Custura\Trane\Http\Livewire;

use Custura\Calendar\Calendar;
use Custura\Trane\Models\Team\Appointment;
use Custura\Trane\Models\Team\TeamProjectUserBind;
use Custura\Trane\Models\Team\TeamProjectTaskBind;
use Custura\Trane\Models\Team\TeamProjectTemplateBind;
use Custura\Trane\Models\Team\TeamProjectClientBind;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class AppointmentsCalendar extends Calendar
{
    public $isModalOpen = false;

    public $selectedAppointment = null;

    public $newAppointment;

    public function events(): Collection
    {
        return Appointment::query()
            ->whereDate('scheduled_at', '>=', $this->gridStartsAt)
            ->whereDate('scheduled_at', '<=', $this->gridEndsAt)
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->where('user_id', '=', Auth::user()->id)
            ->get()
            ->map(function (Appointment $appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->title,
                    'description' => $appointment->notes,
                    'date' => $appointment->scheduled_at,
                ];
            });
    }

    public function projectsBind(): Collection
    {
/*        return TeamProjectUserBind::query()
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->where('user_id', '=', Auth::user()->id)
            ->get();*/
        return TeamProjectUserBind::with('teamProjects')
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->where('user_id', '=', Auth::user()->id)
            ->get();
    }

    public function clientsBind(): Collection
    {
        return TeamProjectClientBind::with('teamProjectClients')
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->get();
    }

    public function tasksBind(): Collection
    {
        return TeamProjectTaskBind::with('teamProjectTasks')
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->get();
    }

    public function templatesBind(): Collection
    {
        return TeamProjectTemplateBind::with('teamProjectTemplates')
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->get();
    }

    public function unscheduledEvents() : Collection
    {
        return Appointment::query()
            ->whereNull('scheduled_at')
            ->where('team_id', '=', Auth::user()->currentTeam->id)
            ->where('user_id', '=', Auth::user()->id)
            ->get();
    }

    public function onDayClick($year, $month, $day)
    {
        $this->isModalOpen = true;

        $this->resetNewAppointment();

        $this->newAppointment['scheduled_at'] = Carbon::today()
            ->setDate($year, $month, $day)
            ->format('Y-m-d');

        $this->newAppointment['team_id'] = Auth::user()->currentTeam->id;
        $this->newAppointment['user_id'] = Auth::user()->id;
        $this->newAppointment['created_by'] = Auth::user()->id;
    }

    public function saveAppointment()
    {
        Appointment::create($this->newAppointment);

        $this->isModalOpen = false;
    }

    public function onEventDropped($eventId, $year, $month, $day)
    {
        $appointment = Appointment::find($eventId);
        $appointment->scheduled_at = Carbon::today()->setDate($year, $month, $day);
        $appointment->save();
    }

    private function resetNewAppointment()
    {
        $this->newAppointment = [
            'title' => '',
            'notes' => '',
            'scheduled_at' => '',
            'start_at' => '',
            'end_at' => '',
            'duration' => '',
            'work_duration' => '',
            'pause' => '',
            'client_id' => '',
            'task_id' => '',
            'priority' => 'normal',
            'team_id' => '',
            'user_id' => '',
            'project_id' => '',
        ];
    }

    public function onEventClick($eventId)
    {
        $this->selectedAppointment = Appointment::find($eventId);
    }

    public function unscheduleAppointment()
    {
        $appointment = Appointment::find($this->selectedAppointment['id']);
        $appointment->scheduled_at = null;
        $appointment->save();

        $this->selectedAppointment = null;
    }

    public function closeAppointmentDetailsModal()
    {
        $this->selectedAppointment = null;
    }

    public function deleteEvent($eventId)
    {
        $appointment = Appointment::find($eventId);
        $appointment->delete();
    }

    public function render() : View
	{
		$events = $this->events();
        return view($this->calendarView)->with([
			'componentId' => $this->id,
            'projectsBind' => $this->projectsBind(),
            'clientsBind' => $this->clientsBind(),
            'tasksBind' => $this->tasksBind(),
            'templatesBind' => $this->templatesBind(),
			'monthGrid' => $this->monthGrid(),
			'events' => $events,
            'unscheduledEvents' => $this->unscheduledEvents(),
			'getEventsForDay' => function ($day) use ($events) {
				return $this->getEventsForDay($day, $events);
			},
		]);
	}
}
