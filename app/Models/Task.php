<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'description',
        'due_date',
        'due_time',
        'is_completed',
        'taskcategory_id',
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the taskcategory that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskcategory(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class);
    }
}
