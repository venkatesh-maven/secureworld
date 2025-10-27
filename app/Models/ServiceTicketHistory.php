<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTicketHistory extends Model
{
    protected $fillable = [
        'service_ticket_id', 'changed_by', 'action', 'summary', 'previous', 'changes'
    ];

    protected $casts = [
        'previous' => 'array',
        'changes' => 'array',
    ];

    public function ticket()
    {
        return $this->belongsTo(ServiceTicket::class, 'service_ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
