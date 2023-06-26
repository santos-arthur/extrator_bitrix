<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $table = 'stages';

    protected $fillable = [
        'id',
        'title',
        'sort',
        'color',
        'group_id',
        'default'
    ];

    public $timestamps = false;
}
