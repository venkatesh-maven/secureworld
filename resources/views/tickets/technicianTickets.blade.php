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
    #ticketsTable tbody tr{
        border-bottom:none !important;
    }
    #ticketsTable tr td{
        border-bottom:none;
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
            <table id="ticketsTable" class="table table-hover align-middle mb-0" style="width:100%,tableLayout:fixed">
                <thead class="table-light sticky-top">
                    <tr class="text-nowrap text-center">
                        <!--<th>S.No</th>-->
                        <th>Technician</th>
                        @php  
                            
                            $statusCounts =[]; 
                            $statusCounts['grand_total'] = 0;
                        @endphp
                            @foreach($statuses as $status)
                               @php  
                               $statusCounts[$status->name] = 0;
                                @endphp
                                <th>{{ $status->name }}</th>
                            @endforeach
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach($ticketsList as $index => $ticket)
                        @php
                           $counts = [];
                            foreach(explode(',', $ticket->total_tickets) as $item){
                                $item = trim($item);
                                [$name, $count] = explode('-', $item);
                                $counts[$name] = (int)$count;
                              
                                    $statusCounts[$name] = (int)$statusCounts[$name]+(int)$count;
                                    $statusCounts['grand_total'] = $statusCounts['grand_total']+(int)$ticket->total;
                            }
                        @endphp
                            
                        <tr class="text-center" data-user="{{$ticket->technician_id}}">
                           <!-- <td>{{ $loop->iteration }}</td> -->
                            <td class="fw-bold">{{ $ticket->technician_name }}</td>
                            
                            @foreach($statuses as $status)
                                  @php $statusId = $statusList[$status->name]; @endphp
                                <td style="cursor:pointer"data-status="{{$status->name}}" class="technician">{{ $counts[$status->name] ?? 0 }}</td>
                            @endforeach
                            <td class="text-end">{{$ticket->total}}</td>   
                        </tr>
                    @endforeach
                     <tr class="text-nowrap text-center">
                        <th>Total</th>
                            @foreach($statuses as $status)
                                <th>{{ $statusCounts[$status->name] }}</th>
                            @endforeach
                            <th class="text-end">{{ $statusCounts['grand_total']}}</th>                        
                    </tr>
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

    .modal-dialog.modal-xl {
        max-width: 90%; /* keep wide if needed */
    }

    .modal-content {
        height: 90vh; /* 90% of viewport height */
    }

    .modal-body {
        max-height: 75vh; /* scrollable content area */
        overflow-y: auto;
    }
</style>

</style>

<script>
$(document).ready(function () {
    $('table td.technician').on('click', function() {
        var status = $(this).data('status');
        status = status.replace(' ', '_');
        var tr = $(this).closest('tr');
        var userId = tr.data('user');
        //window.open('/tickets/serviceTickets/'+userId+'/'+status, '_blank');
        $('#modelTable tbody').empty();
        $.ajax({
            url: '/tickets/serviceTickets/'+userId+'/'+status,
            type: 'GET',
            dataType: 'json',
            success: function(tickets) {
                console.log('response is '+tickets);
                if (tickets.length > 0) {
                    $.each(tickets, function(index, ticket) {
                        $('#modelTable tbody').append(`
                            <tr>
                                <td>${ticket.service_id}</td>
                                <td>${ticket.customer_info}</td>
                                <td>${ticket.age}</td>
                                <td>${ticket.mobile}</td>
                                <td>${ticket.order_type}</td>
                                <td>${ticket.created_on}</td>
                                <td>${ticket.user_status}</td>
                                <td>${ticket.product_category}</td>
                                <td>${ticket.product_description}</td>
                                <td>${ticket.site_code}</td>
                                <td>${ticket.call_bifurcation}</td>
                                <td>${ticket.changed_on}</td>
                                <td>${ticket.sla}</td>
                                <td>${ticket.field_group}</td>
                                <td>${ticket.deferment_date}</td>
                                <td>${ticket.call_completion_date}</td>
                                <td>${ticket.comments}</td>
                                <td>${ticket.last_updated_on}</td>
                                <td>${ticket.part_required}</td>
                                
                            </tr>
                        `);
                    });
                } else {
                    $('#modelTable tbody').append(`
                        <tr>
                            <td colspan="4" class="text-center">No tickets found.</td>
                        </tr>
                    `);
                }

                // Show modal after data is loaded
                $('#ticketsModal').modal('show');
            },
            error: function() {
                alert('Unable to fetch tickets.');
            }
        });
    });
});
</script>

<div class="modal fade" id="ticketsModal" tabindex="-1">
  <div class="modal-dialog modal-xl"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Technician Tickets</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive" style="max-height: 72vh; overflow-y: auto;">
            <table class="table table-striped" id="modelTable">
            <thead>
                <tr>
                    <th>Service ID</th>
                    <th>Customer Info</th>
                    <th>Age (Days)</th>
                    <th>Mobile</th>
                    <th>Order Type</th>
                    <th>Created On</th>
                    <th>User Status</th>
                    <th>Product Category</th>
                    <th>Product Description</th>
                    <th>Site Code</th>
                    <th>Call Bifurcation</th>
                    <th>Changed On</th>
                    <th>SLA</th>
                    <th>Field Group</th>
                    <th>Deferment Date</th>
                    <th>Call Completion Date</th>
                    <th>Comments</th>
                    <th>Last Updated On</th>
                    <th>Part Required</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be added here dynamically -->
            </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
@endsection
