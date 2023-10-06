<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    
    protected $fillable = [
        'name',
        'description',
        'category',
        'due_date',
        'priority_level',
    ];
}