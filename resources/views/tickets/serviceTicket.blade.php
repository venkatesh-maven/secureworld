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
<!---datatable -->

<!-- end -->
<main id="main-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @error('serviceMonitor')
                    <div class="alert alert-danger text-center">{{ $message }}</div>
                @enderror
                   @error('serviceOrder')
                    <div class="alert alert-danger text-center">{{ $message }}</div>
                @enderror
                
            @if(auth()->user() && auth()->user()->role && auth()->user()->role->role_name != 'technician')    
<!--<div class="content">-->
<!--    <div class="row g-3 justify-content-center">-->
        
        <!-- 🔹 Import Service Monitor -->
<!--        <div class="col-md-5 col-sm-6">-->
<!--            <form action="{{ route('tickets.importServiceMonitor') }}" -->
<!--                  method="POST" -->
<!--                  enctype="multipart/form-data" -->
<!--                  class="border rounded-3 p-3 shadow-sm bg-white small-form">-->
<!--                @csrf-->

<!--                <h6 class="text-center mb-3 text-primary fw-bold">-->
<!--                    Import Service Monitor-->
<!--                </h6>-->

<!--                <div class="row g-2 align-items-end">-->
<!--                    <div class="col-12 col-md-5">-->
<!--                        <label for="mode" class="form-label fw-semibold mb-1 small">-->
<!--                            Import Mode <span class="text-danger">*</span>-->
<!--                        </label>-->
<!--                        <select name="mode" id="mode" class="form-select form-select-sm" required>-->
<!--                            <option value="">-- Select Mode --</option>-->
<!--                            <option value="insert">Capture new</option>-->
<!--                            <option value="edit">Update</option>-->
<!--                        </select>-->
<!--                    </div>-->

<!--                    <div class="col-12 col-md-5">-->
<!--                        <label for="serviceMonitor" class="form-label fw-semibold mb-1 small">-->
<!--                            File <span class="text-danger">*</span>-->
<!--                        </label>-->
<!--                        <input type="file" -->
<!--                               id="serviceMonitor" -->
<!--                               name="serviceMonitor" -->
<!--                               class="form-control form-control-sm" -->
<!--                               required -->
<!--                               title="Select Import Service Monitor Excel or CSV file">-->
<!--                    </div>-->

<!--                    <div class="col-12 col-md-2 text-center text-md-start">-->
<!--                        <button type="submit" class="btn btn-sm btn-info w-100 fw-semibold mt-2 mt-md-0">-->
<!--                            <i class="fas fa-upload me-1"></i> Go-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <small class="text-muted d-block text-center mt-2" style="font-size: 0.75rem;">-->
<!--                    (.xlsx, .xls, .csv)-->
<!--                </small>-->
<!--            </form>-->
<!--        </div>-->

        <!-- 🔹 Import Service Order -->
<!--        <div class="col-md-5 col-sm-6">-->
<!--            <form action="{{ route('tickets.importServiceOrder') }}" -->
<!--                  method="POST" -->
<!--                  enctype="multipart/form-data" -->
<!--                  class="border rounded-3 p-3 shadow-sm bg-white small-form">-->
<!--                @csrf-->

<!--                <h6 class="text-center mb-3 text-primary fw-bold">-->
<!--                    Import Service Order-->
<!--                </h6>-->

<!--                <div class="row g-2 align-items-end">-->
<!--                    <div class="col-12 col-md-9">-->
<!--                        <label for="serviceOrder" class="form-label fw-semibold mb-1 small">-->
<!--                            File <span class="text-danger">*</span>-->
<!--                        </label>-->
<!--                        <input type="file" -->
<!--                               id="serviceOrder" -->
<!--                               name="serviceOrder" -->
<!--                               class="form-control form-control-sm" -->
<!--                               required -->
<!--                               title="Select Import Service Order Excel or CSV file">-->
<!--                    </div>-->

<!--                    <div class="col-12 col-md-3 text-center text-md-start">-->
<!--                        <button type="submit" class="btn btn-sm btn-info w-100 fw-semibold mt-2 mt-md-0">-->
<!--                            <i class="fas fa-upload me-1"></i> Go-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <small class="text-muted d-block text-center mt-2" style="font-size: 0.75rem;">-->
<!--                    (.xlsx, .xls, .csv)-->
<!--                </small>-->
<!--            </form>-->
<!--        </div>-->

<!--    </div>-->
<!--</div>-->
@endif
        <div class="card shadow-sm p-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!--<h5 class="fw-bold text-primary mb-0">Service Tickets</h5>-->
        <span class="badge bg-info text-dark px-3 py-2">
            Total: {{ count($tickets) }}
        </span>
        <a href="{{ route('tickets.export', ['status' => request('status')]) }}" class="btn btn-success mb-3">
    Export Tickets
</a>
    </div>
    


    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
        <table id="ticketsTable" class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-light sticky-top">
                <tr class="text-nowrap text-center">
                    @if(auth()->user() && auth()->user()->role && auth()->user()->role->role_name === 'superadmin')
                    <th>Actions</th>
                     @endif
                    <th>S.No</th>
                    <th>Service ID</th>
                    <th>Customer Info</th>
                    <!--<th>Item Category</th>-->
                    <th>Age (Days)</th>
                    <th>Mobile</th>
                    <th>Order Type</th>
                    <th>Created On</th>
                    <th>User Status</th>
                    <th>Product Category</th>
                    <th>Product Description</th>
                    <th>Technician</th>
                    <th>Site Code</th>
                    <th>Call Bifurcation</th>
                    
                    <th>Changed On</th>
                    
                    <!--<th>Serial No</th>-->
                    <!--<th>Brand</th>-->
                    <!--<th>Sales Office</th>-->
                    <!--<th>Confirmation No</th>-->
                    <!--<th>Transaction Type</th>-->
                    <!--<th>Status</th>-->
                    <!--<th>Availability</th>-->
                    <!--<th>Higher Level Item</th>-->
                    <th>SLA</th>
                    <!--<th>Billing</th>-->
                    <!--<th>Bill To Party</th>-->
                    <!--<th>PR Number</th>-->
                    <!--<th>Invoice Number</th>-->
                    <!--<th>STO Number</th>-->
                    <!--<th>SO Number</th>-->
                    <!--<th>Article Code</th>-->
                    <!--<th>Address</th>-->
                    <!--<th>Service Characteristic</th>-->
                    <!--<th>Product Source</th>-->
                    <!--<th>State</th>-->
                    <!--<th>City</th>-->
                    <!--<th>Warranty</th>-->
                    <!--<th>Deferment Date</th>-->
                    
                    
                    <th>Field Group</th>
                    <th>Deferment Date</th>
                    <th>Call Completion Date</th>
                    <th>Comments</th>
                    <th>Last Updated On</th>
                    <th>Part Required</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        @if(auth()->user() && auth()->user()->role && auth()->user()->role->role_name === 'superadmin')
        <td>
            <form action="{{ route('servicetickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
    @endif
                        <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                        <td>
    <a href="{{ route('tickets.serviceedit', $ticket->id) }}" class="text-decoration-none">
        {{ $ticket->service_id }}
    </a>
</td>

                        <td>{{ $ticket->sold_to_party }}</td>
                        <!--<td>{{ $ticket->item_category }}</td>-->
                        <td>{{ \Carbon\Carbon::parse($ticket->created_on)->diffInDays(\Carbon\Carbon::today()) }}
 </td>
                        <td>{{ $ticket->mobile }}</td>
                        <td>{{ $ticket->order_type }}</td>
                        <td>{{ $ticket->created_on }}</td>
                        <td>{{ $ticket->user_status }}</td>
                        <td>{{ $ticket->category }}</td>
                        <td>{{ $ticket->product }}</td>
                        <td>{{ $ticket->technician_name ?? 'N/A' }}</td>



                        <td>{{ $ticket->site_code }}</td>
                        <td>{{ $ticket->call_bifurcation }}</td>
                        
                        <td>{{ $ticket->changed_on }}</td>
                        
                        <!--<td>{{ $ticket->serial_no }}</td>-->
                        <!--<td>{{ $ticket->brand }}</td>-->
                        <!--<td>{{ $ticket->sales_office }}</td>-->
                        <!--<td>{{ $ticket->confirmation_no }}</td>-->
                        <!--<td>{{ $ticket->transaction_type }}</td>-->
                        <!--<td>-->
                        <!--    <span class="badge bg-{{ strtolower($ticket->status) == 'completed' ? 'success' : (strtolower($ticket->status) == 'pending' ? 'warning text-dark' : 'secondary') }}">-->
                        <!--        {{ ucfirst($ticket->status) }}-->
                        <!--    </span>-->
                        <!--</td>-->
                        <!--<td>{{ $ticket->availability }}</td>-->
                        <!--<td>{{ $ticket->higher_level_item }}</td>-->
                        <td>{{ $ticket->sla }}</td>
                        <!--<td>{{ $ticket->billing }}</td>-->
                        <!--<td>{{ $ticket->bill_to_party }}</td>-->
                        <!--<td>{{ $ticket->pr_number }}</td>-->
                        <!--<td>{{ $ticket->invoice_number }}</td>-->
                        <!--<td>{{ $ticket->sto_number }}</td>-->
                        <!--<td>{{ $ticket->so_number }}</td>-->
                        <!--<td>{{ $ticket->article_code }}</td>-->
                        <!--<td>{{ $ticket->address }}</td>-->
                        <!--<td>{{ $ticket->service_characteristi }}</td>-->
                        <!--<td>{{ $ticket->product_source }}</td>-->
                        <!--<td>{{ $ticket->state }}</td>-->
                        <!--<td>{{ $ticket->city }}</td>-->
                        <!--<td>{{ $ticket->warranty }}</td>-->
                        <!--<td>{{ $ticket->deferment_date }}</td>-->
                        
                        
                        <td>{{ $ticket->field_category }}</td>
                        <td>{{ $ticket->deferment_date }}</td>
                        <td>{{ $ticket->call_completion_date }}</td>
                        <td>{{ $ticket->Comments }}</td>
                        <td>{{ $ticket->updated_at }}</td>
                        <td>{{ $ticket->part_Required }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    /* 🔹 Add clear row separation and borders */
    #ticketsTable tbody tr {
        border-bottom: 2px solid #dee2e6; /* slightly thicker line */
    }

    /*#ticketsTable tbody tr:hover {*/
        background-color: #f8f9fa; /* light gray highlight on hover */
    /*    transition: background-color 0.2s ease-in-out;*/
    /*}*/



    /*#ticketsTable thead th {*/
    /*    background-color: #e9ecef;*/
    /*    color: #212529;*/
    /*    border-bottom: 2px solid #adb5bd !important;*/
    /*    font-weight: 600;*/
    /*}*/

    /*#ticketsTable {*/
    /*    border-collapse: separate !important;*/
    /*    border-spacing: 0;*/
    /*}*/
    
    /* Compact table styles */
    #ticketsTable th,
    #ticketsTable td {
        font-size: 0.75rem;        /* smaller font */
        padding: 0.35rem 0.5rem;   /* reduced padding */
        
    }

    
</style>


<script>
$(document).ready(function () {
    $('#ticketsTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        searching: true,
        responsive: true,
        scrollX: true,
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
});
</script>

    </div>
</main>
@endSection