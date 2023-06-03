<?php

namespace Custura\Trane\Http\Controllers;

use Custura\Trane\Http\Requests\StorePrivatAppointmentRequest;
use Custura\Trane\Http\Requests\UpdatePrivatAppointmentRequest;
use Custura\Trane\Models\User\Appointment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PrivatAppointmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('privat_appointment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = auth()->user()->privatAppointments();

        return view('appointment.user.index', compact('appointments'));
    }

    public function create()
    {
        abort_if(Gate::denies('privat_appointment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('appointment.user.create');
    }

    public function store(StorePrivatAppointmentRequest $request)
    {
    	$appointment = new Appointment();
    	$appointment->description = $request->description;
        $appointment->start_date = $request->start_date;
        $appointment->end_date = $request->end_date;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->user_id = auth()->user()->id;
    	$appointment->save();

        return redirect()->route('appointments.index');
    }

    public function show(Appointment $appointment)
    {
        abort_if(Gate::denies('privat_appointment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->id == $appointment->user_id)
        {
            return view('appointment.user.show', compact('appointment'));
        }
        else {
            return redirect('/appointments');
        }
    }

    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('privat_appointment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->id == $appointment->user_id)
        {
            return view('appointment.user.edit', compact('appointment'));
        }
        else {
            return redirect('/appointments');
        }
    }

    public function update(UpdatePrivatAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()->route('appointments.index');
    }

    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('privat_appointment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->id == $appointment->user_id)
        {
            $appointment->delete();
            return redirect()->route('appointments.index');
        }
        else {
            return redirect('/appointments');
        }
    }
}
