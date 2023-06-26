<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagSprints extends Model
{
    protected $table = 'tag_sprints';

    protected $fillable = [
        'id',
        'task_id',
        'sprint_number',
        'sprint_tag',
    ];

    public $timestamps = false;
}
