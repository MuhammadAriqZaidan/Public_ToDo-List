<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// app/Models/Todo.php

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'is_done', 'due_date', 'attachment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

