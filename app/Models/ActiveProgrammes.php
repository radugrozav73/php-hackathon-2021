<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Programmes;
use App\Models\User;

class ActiveProgrammes extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'programmes_id',
        'cnp',
        'room_name',
        'start_date',
        'end_date',
    ];

    public function programme(){
        return $this->belongsTo(Programmes::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
