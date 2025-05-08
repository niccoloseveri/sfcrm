<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TechnicalAssistence extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'description',
        'due_date',
        'due_time',
        'is_completed',
        'report_path',
    ];

    protected $casts = [
        'due_date' => 'date',
        'due_time' => 'datetime',
        'is_completed' => 'boolean',
    ];

    /**
     * Get the customer that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the employee that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assistente(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
