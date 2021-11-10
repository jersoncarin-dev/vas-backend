<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Pusher\PushNotifications\PushNotifications;

class Appointment extends Model
{
    use HasFactory;

    public $guarded = [];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($appointment) {
            $staffs = User::where('role','ADMIN')
                ->orWhere('role','STAFF')
                ->get()
                ->map(function($staff) {
                    return "user_id_".$staff->id;
                })
                ->toArray();
            
            app(PushNotifications::class)->publishToUsers(
                $staffs,
                array(
                  "web" => array(
                    "notification" => array(
                      "title" => "Newly Appointment received!",
                      "body" => $appointment->medicine->name. " appointment has been created."
                    )
                  )
              ));
        });

        static::deleted(function ($appointment) {
            $user = Auth::user();

            if($user->role === 'ADMIN' || $user->role === 'STAFF') {
                app(PushNotifications::class)->publishToUsers(
                    array("user_id_".$appointment->user_id),
                    array(
                      "web" => array(
                        "notification" => array(
                          "title" => "Newly Appointment cancelled!",
                          "body" => $appointment->medicine->name. " appointment has been removed by the staff."
                        )
                      )
                  ));
            }

            if($user->role === 'CLIENT') {
                $staffs = User::where('role','ADMIN')
                    ->orWhere('role','STAFF')
                    ->get()
                    ->map(function($staff) {
                        return "user_id_".$staff->id;
                    })
                    ->toArray();

                app(PushNotifications::class)->publishToUsers(
                    $staffs,
                    array(
                      "web" => array(
                        "notification" => array(
                          "title" => "Newly Appointment cancelled!",
                          "body" => $appointment->medicine->name. " appointment has been cancelled by client."
                        )
                      )
                  ));
            }

        });

        static::updated(function ($appointment) {
            app(PushNotifications::class)->publishToUsers(
                array("user_id_".$appointment->user_id),
                array(
                  "web" => array(
                    "notification" => array(
                      "title" => "Newly Appointment approved!",
                      "body" => $appointment->medicine->name. " appointment has been approved by the staff."
                    )
                  )
              ));
        });
    }
}
