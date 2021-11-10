<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Medicine extends Model
{
    use HasFactory;

    public $guarded = [];

    public function isAppointed()
    {
        return Appointment::where([
            'medicine_id' => $this->id,
            'user_id' => Auth::id()
        ])->exists();
    }
}
