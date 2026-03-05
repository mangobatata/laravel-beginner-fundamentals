<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // $fillable  le dice a Laravel qué campos pueden asignarse masivamente.
    protected $fillable = [
        'title',
        'description',
        'long_description',
        'completed', 
    ];

    public function toggleComplete()
    {
        $this->completed = !$this->completed;
        $this->save();
    }
}
