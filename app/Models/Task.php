<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assigned_to',
        'category_id',
        'title',
        'description',
        'deadline',
        'file',
        'accepted_status',
        'status'  
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
