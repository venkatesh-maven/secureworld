@extends('layouts.master')

@section('content')
<style>
    .importserviceform{
        font-family:sans-serif;
    }
    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
    }
    .service-table{
        font-family:serif;
        font-size:small;
    }
</style>

<main id="main-container">
    <div class="card shadow-sm p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            Technicians
        </div>
        @php
            $statusList = [];
            foreach ($statuses as $status) {
                $statusList[$status->name] = $status->id;
            }
        @endphp
        <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
            <table id="ticketsTable" class="table table-hover table-bordered align-middle mb-0" style="width:100%,tableLayout:fixed">
                <thead class="table-light sticky-top">
                    <tr class="text-nowrap text-center">
                        <!--<th>S.No</th>-->
                        <th style="width:120px">Technician</th>
                    
                            @foreach($statuses as $status)
                                <th style="width:120px">{{ $status->name }}</th>
                            @endforeach
                        
                    </tr>
                </thead>

                <tbody>
                    @foreach($ticketsList as $index => $ticket)
                        @php
                            $counts = [];
                            foreach(explode(',', $ticket->total_tickets) as $item)
                                $item = trim($item);
                                [$name, $count] = explode('-', $item);
                                $counts[$name] = (int)$count;
                        @endphp

                        <tr class="text-center" data-user="{{$ticket->technician_id}}">
                           <!-- <td>{{ $loop->iteration }}</td> -->
                            <td class="fw-bold text-primary" style="width:120px">{{ $ticket->technician_name }}</td>

                            @foreach($statuses as $status)
                                  @php $statusId = $statusList[$status->name]; @endphp
                                <td style="width:120px;cursor:pointer"data-status="{{$status->name}}" class="technician">{{ $counts[$status->name] ?? 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<style>
    #ticketsTable tbody tr {
        border-bottom: 2px solid #dee2e6;
    }

    #ticketsTable th,
    #ticketsTable td {
        font-size: 0.75rem;
        padding: 0.35rem 0.5rem;
    }
   #ticketsTable table {
    table-layout: fixed;
    width: 100%;
    }

    #ticketsTable th, td {
    min-width: 120px;
    max-width: 120px;
    word-break: break-word;
    }
</style>

<script>
$(document).ready(function () {
    $('#ticketsTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        searching: false,
        scrollX: true,
        responsive: false,
        autoWidth:false,
        language: {
            search: "🔍 Search:",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ tickets",
            infoEmpty: "No tickets available",
            paginate: {
                previous: "← Prev",
                next: "Next →"
            }
        }
    });

    $('table td.technician').on('click', function() {
        var status = $(this).data('status');
        var tr = $(this).closest('tr');
        var userId = tr.data('user');
        window.open('/tickets/serviceTickets/'+userId+'?status='+status, '_blank');
    });
});
$('#ticketsTable').columns.adjust().draw();
</script>

</main>
@endsection
