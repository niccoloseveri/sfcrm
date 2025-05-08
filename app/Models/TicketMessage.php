<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'message',
        'is_staff',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
