<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $with = ['children'];
    protected $fillable = [
        'title', 'description', 'is_completed', 'due_at', 'parent_id'
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
}
