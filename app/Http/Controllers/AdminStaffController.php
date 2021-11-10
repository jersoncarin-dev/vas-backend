<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\PushNotifications\PushNotifications;

class AdminStaffController extends Controller
{
    public function medicines()
    {
        return view('staff.home',[
            'medicines' => Medicine::latest()
                ->paginate()
        ]);
    }

    public function medicineDelete(Request $request)
    {
        if($medicine = Medicine::find($request->id)) {
            $medicine->delete();

            return redirect()->back()->withMessage('Medicine deleted successfully');
        }

        return abort(404);
    }

    public function medicineShow(Request $request)
    {
        if($medicine = Medicine::find($request->id)) {
            return response()->json($medicine);
        }

        return abort(404);
    }

    public function medicineEdit(Request $request)
    {
        $file = $request->file('thumbnail');
        $thumbnail = null;

        if(!is_null($file)) {
            $thumbnail = url('dist/img/'.$file->getClientOriginalName());
            $file->move(public_path('dist/img'),$file->getClientOriginalName());
        }

        if($medicine = Medicine::find($request->id)) {
            $fields = [
                'name' => $request->name,
                'description' => $request->description,
            ];

            if(!is_null($thumbnail)) {
                $fields['thumbnail'] = $thumbnail;
            }

            $medicine->update($fields);

            return redirect()->back()->withMessage("Medicine successfully updated");
        }

        return abort(404);
    }

    public function medicineAdd(Request $request)
    {
        $file = $request->file('thumbnail');

        $thumbnail = url('dist/img/'.$file->getClientOriginalName());
        $file->move(public_path('dist/img'),$file->getClientOriginalName());

        Medicine::create([
            'name' => $request->name,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'is_available' => true
        ]);

        return redirect()->back()->withMessage("Medicine added successfully");
    }

    public function appointments()
    {
        $calendars = Appointment::with('user')
            ->where('is_approved',false)
            ->latest()
            ->get()
            ->map(function($appointment) {
                return [
                    'id' => $appointment->id,
                    'calendarId' => $appointment->id,
                    'title' => $appointment->user->name.'('.$appointment->medicine->name.')',
                    'category' => 'allday',
                    'dueDateClass' => '',
                    'start' => $appointment->appointment_date,
                    'end' => $appointment->appointment_date,
                ];
            });

        return view('staff.appointments',[
            'calendars' => $calendars
        ]);
    }

    public function rejectOrApprove(Request $request)
    {
        if(!($appointment = Appointment::find($request->id))) {
            return abort(404);
        }

        $approve = false;

        if($request->has('reject')) {
            $appointment->delete();
        } else if($request->has('approve')) {
            $appointment->update([
                'is_approved' => true
            ]);

            $approve = true;
        } else {
            return abort(500);
        }

        return redirect()
            ->back()
            ->withMessage('Appointment has been ' . ($approve ? 'approved' : 'rejected') . 'successfully.');
    }

    public function reminders()
    {
        $clients = User::where('role','CLIENT')->get();

        return view('staff.reminders',compact('clients'));
    }

    public function sendReminder(Request $request,PushNotifications $pn)
    {
        $pn->publishToUsers(
            array("user_id_".$request->id),
            array(
              "web" => array(
                "notification" => array(
                  "title" => $request->title ?? 'No title',
                  "body" => $request->message ?? 'No body'
                )
              )
          ));

        return redirect()->back()->withMessage("Reminder send successfully");
    }
}
