<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaraZeus\Thunder\Support\TicketNo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'ticket_no',
        'email',
        'token',
        'status',
        'priority',
    ];

    public static function boot(){
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->token = Str::uuid();
            $ticket->ticket_no = TicketNo::get();

        });
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}
