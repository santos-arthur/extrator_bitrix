<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leadtimes extends Model
{
    protected $table = 'leadtimes';

    protected $fillable = [
        'id',
        'task_id',
        'stage_id',
        'entered_at',
        'left_at'
    ];

    public $timestamps = false;
}
