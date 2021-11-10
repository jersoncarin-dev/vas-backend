<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function medicines()
    {
        return view('client.home',[
            'medicines' => Medicine::latest()->paginate()
        ]);
    }

    public function appoint(Request $request)
    {
        $date = $request->appointment_date ?? date('Y-m-d');
        
        if(!($medicine = Medicine::find($request->medicine_id))) {
            return abort(404);
        }

        if($medicine->isAppointed()) {
            return abort(403);
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'medicine_id' => $request->medicine_id,
            'appointment_date' => $date,
            'is_approved' => false
        ]);

        return redirect()
            ->back()
            ->withMessage("{$medicine->name} has been appointed successfully. You may check to appointment page to verify.");
    }

    public function appointments()
    {
        $appointments = Appointment::with('medicine')
            ->where('user_id',Auth::id())
            ->latest()
            ->paginate();

        return view('client.appointments',[
            'appointments' => $appointments
        ]);
    }

    public function cancelAppointments(Request $request)
    {
        $appointment = Appointment::find($request->id);

        if(!$appointment) {
            return abort(404);
        }

        if($appointment->is_approved) {
            return abort(403);
        }

        $appointment->delete();

        return redirect()->back()->withMessage("Appointment successfully cancelled.");
    }
}
