<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromCollection, WithHeadings
{
    protected $ticketsQuery;

    public function __construct($ticketsQuery)
    {
        $this->ticketsQuery = $ticketsQuery;
    }

    public function collection()
    {
        // Execute the query and return results
        return $this->ticketsQuery->get();
    }

    public function headings(): array
    {
        return [
            'Service ID',
            'Customer Info',
            'Age (Days)',
            'Mobile',
            'Order Type',
            'Created On',
            'User Status',
            'Product Category',
            'Product Description',
            'Technician',
            'Site Code',
            'Call Bifurcation',
            'Part Required',
            'Changed On',
            'SLA',
            
            'Field Team',
     
            'Call Completion Date',
            'Comments',
            'Last updated On',
            'Status'
           
        ];
    }
}
