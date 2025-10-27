<?php 
namespace App\Observers;

use App\Models\serviceTickets;
use App\Models\ServiceTicketHistory;
use Illuminate\Support\Facades\Auth;

class ServiceTicketObserver
{
    /**
     * Triggered automatically when a ticket is updated.
     */
    public function updating(serviceTickets $ticket)
    {
        $original = $ticket->getOriginal();
        $dirty = $ticket->getDirty(); // changed fields only

        if (empty($dirty)) {
            return; // nothing changed
        }

        // Prepare readable summary
        $summary = collect($dirty)->map(function ($newValue, $key) use ($original) {
            $oldValue = $original[$key] ?? null;
            return "{$key}: '{$oldValue}' → '{$newValue}'";
        })->implode('; ');

        // Create history record
        ServiceTicketHistory::create([
            'service_ticket_id' => $ticket->id,
            'changed_by'        => Auth::id(),
            'action'            => 'update',
            'summary'           => substr($summary, 0, 1000),
            'previous'          => array_intersect_key($original, $dirty),
            'changes'           => $dirty,
        ]);
    }
}
