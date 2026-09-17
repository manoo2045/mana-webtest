<?php

namespace App\Infrastructure\Task;

use Illuminate\Database\Eloquent\Model;

class EloquentTaskModel extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['title', 'is_completed'];

    public $timestamps = false;
}