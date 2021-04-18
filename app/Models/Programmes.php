<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ActiveProgrammes;

class Programmes extends Model
{
    use HasFactory;

    protected $fillable=[
        'start_date',
        'end_date',
        'room_name',
        'user_id',
        'max_number',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function activeprograms(){
        return $this->hasMany(ActiveProgrammes::class);
    }
}
