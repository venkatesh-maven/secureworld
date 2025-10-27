@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
<style>
    
    .block {
        padding: 0.75rem !important;
    }
    .block-content-full {
        padding: 0.75rem !important;
    }
    .item i {
        font-size: 1.5rem !important;
    }
    .fs-1 {
        font-size: 1.25rem !important;
    }
    .text-muted.mb-3 {
        margin-bottom: 0.5rem !important;
        font-size: 0.85rem !important;
    }
    .block-content-sm {
        padding: 0.5rem !important;
    }
</style>


     <main id="main-container">

        <!-- Hero -->
        <div class="content">
          <div class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
            <div>
              <h1 class="h3 mb-1">
                Dashboard
              </h1>
              <!--<p class="fw-medium mb-0 text-muted">-->
              <!--  Welcome, admin! You have <a class="fw-medium" href="javascript:void(0)">8 new notifications</a>.-->
              <!--</p>-->
            </div>
            <!--<div class="mt-4 mt-md-0">-->
            <!--  <a class="btn btn-sm btn-alt-primary" href="javascript:void(0)">-->
            <!--    <i class="fa fa-cog"></i>-->
            <!--  </a>-->
            <!--  <div class="dropdown d-inline-block">-->
            <!--    <button type="button" class="btn btn-sm btn-alt-primary px-3" id="dropdown-analytics-overview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--      Last 30 days <i class="fa fa-fw fa-angle-down"></i>-->
            <!--    </button>-->
            <!--    <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-analytics-overview">-->
            <!--      <a class="dropdown-item" href="javascript:void(0)">This Week</a>-->
            <!--      <a class="dropdown-item" href="javascript:void(0)">Previous Week</a>-->
            <!--      <div class="dropdown-divider"></div>-->
            <!--      <a class="dropdown-item" href="javascript:void(0)">This Month</a>-->
            <!--      <a class="dropdown-item" href="javascript:void(0)">Previous Month</a>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
       <div class="row items-push">
           
           <style>
    /* Compact and consistent card styling */
    .block {
        padding: 0.75rem !important;
    }
    .block-content-full {
        padding: 0.75rem !important;
    }
    .item i {
        font-size: 1.6rem !important;
    }
    .fs-1 {
        font-size: 1.3rem !important;
    }
    .text-muted.mb-3 {
        margin-bottom: 0.4rem !important;
        font-size: 0.9rem !important;
    }
    .block-content-sm {
        padding: 0.5rem !important;
    }
.card-btn-red {
    background-color: #800000
 !important; /* Bootstrap red */
    color: #fff !important;
    transition: all 0.3s ease;
}

.card-btn-red a {
    color: #fff !important;
    text-decoration: none;
}

.card-btn-red:hover {
    background-color: #800000 !important; /* Darker red on hover */
}

.card-btn-red a:hover {
    text-decoration: underline;
}

.card-btn-purple {
    background-color: #6f42c1 !important; /* Bootstrap purple */
    color: #fff !important;
    transition: all 0.3s ease;
}

.card-btn-purple a {
    color: #fff !important;
    text-decoration: none;
}

.card-btn-purple:hover {
    background-color: #59359c !important; /* Slightly darker on hover */
}

.card-btn-purple a:hover {
    text-decoration: underline;
}

.card-btn-green {
    background-color: #198754 !important; /* Bootstrap green */
    color: #fff !important;
    transition: all 0.3s ease;
}

.card-btn-green a {
    color: #fff !important;
    text-decoration: none;
}

.card-btn-green:hover {
    background-color: #146c43 !important; /* Darker green on hover */
}

.card-btn-green a:hover {
    text-decoration: underline;
}


</style>

<div class="row g-3 mb-3">

    <!-- Technician Not Assigned -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 ">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-user-slash text-warning"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $noTechnician ?? 0 }}</div>
                <div class="text-muted mb-3"> UnAssigned</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-red">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'no_technician']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- High Priority – Visit Due -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 ">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-exclamation-circle text-danger"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $highPriority ?? 0 }}</div>
                <div class="text-muted mb-3">High Priority – Visit Due</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-red">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'high_priority']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Deferment Date Crossed -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 ">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-calendar-times text-danger"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $defermentCrossed ?? 0 }}</div>
                <div class="text-muted mb-3">Deferment Date Crossed</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-red">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'deferment_crossed']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Visit Done - SBP Action -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100 ">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-user-check text-success"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $visitDone ?? 0 }}</div>
                <div class="text-muted mb-3">Visit Done - SBP Action</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-red">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'visit_done']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Open Tickets -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-folder-open text-primary"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $openTickets ?? 0 }}</div>
                <div class="text-muted mb-3">Open Tickets</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-red">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'open']) }}">
                    View Open Tickets <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Sent to Vendor -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-truck text-secondary"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $sentToVendor ?? 0 }}</div>
                <div class="text-muted mb-3">Sent to Vendor</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-purple">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'sent_to_vendor']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- RFC / Backend Cancellation -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-ban text-danger"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $rfcCancellation ?? 0 }}</div>
                <div class="text-muted mb-3">RFC / Backend Cancellation</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-purple">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'rfc_cancellation']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Technically Completed -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-check-circle text-success"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $technicallyCompleted ?? 0 }}</div>
                <div class="text-muted mb-3">Technically Completed</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-purple">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'technically_completed']) }}">
                    View Completed <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-check-double text-success"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $completed ?? 0 }}</div>
                <div class="text-muted mb-3">Completed</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-purple">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'completed']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Transferred -->
    <div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-random text-primary"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $transferred ?? 0 }}</div>
                <div class="text-muted mb-3">Transferred</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-purple">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'transferred']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>
<div class="col-6 col-lg-3">
    <div class="block block-rounded text-center d-flex flex-column h-100">
        <div class="block-content block-content-full flex-grow-1">
            <div class="item bg-body mx-auto my-2 rounded-3">
                <i class="fa fa-exclamation-circle text-danger"></i>
            </div>
            <div class="fs-1 fw-bold">{{ $notClosedPravah ?? 0 }}</div>
            <div class="text-muted mb-3">Not Closed in Pravah</div>
        </div>
        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-green">
            <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'notclosedpravah']) }}">
                View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
        </div>
    </div>
</div>

<div class="col-6 col-lg-3">
        <div class="block block-rounded text-center d-flex flex-column h-100">
            <div class="block-content block-content-full flex-grow-1">
                <div class="item bg-body mx-auto my-2 rounded-3">
                    <i class="fa fa-door-closed text-primary"></i>
                </div>
                <div class="fs-1 fw-bold">{{ $closerequests ?? 0 }}</div>
                <div class="text-muted mb-3">Close Requests</div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-green">
                <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'closerequests']) }}">
                    View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-3">
    <div class="block block-rounded text-center d-flex flex-column h-100">
        <div class="block-content block-content-full flex-grow-1">
            <div class="item bg-body mx-auto my-2 rounded-3">
                <i class="fa fa-lock text-success"></i>
            </div>
            <div class="fs-1 fw-bold">{{ $closedTickets ?? 0 }}</div>
            <div class="text-muted mb-3">Closed</div>
        </div>
        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-green">
            <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'closed']) }}">
                View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
        </div>
    </div>
</div>

<div class="col-6 col-lg-3">
    <div class="block block-rounded text-center d-flex flex-column h-100">
        <div class="block-content block-content-full flex-grow-1">
            <div class="item bg-body mx-auto my-2 rounded-3">
                <i class="fa fa-heartbeat text-success"></i>

            </div>
            <div class="fs-1 fw-bold">{{ $live ?? 0 }}</div>
            <div class="text-muted mb-3">Live</div>
        </div>
        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-green">
            <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'live']) }}">
                View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
        </div>
    </div>
</div>

<div class="col-6 col-lg-3">
    <div class="block block-rounded text-center d-flex flex-column h-100">
        <div class="block-content block-content-full flex-grow-1">
            <div class="item bg-body mx-auto my-2 rounded-3">
                <i class="fa fa-exclamation-triangle text-warning"></i>

            </div>
            <div class="fs-1 fw-bold">{{ $backend_cancelation ?? 0 }}</div>
            <div class="text-muted mb-3">Backend cancelation</div>
        </div>
        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-green">
            <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'Tickets Closed Today']) }}">
                View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
        </div>
    </div>
</div>

<div class="col-6 col-lg-3">
    <div class="block block-rounded text-center d-flex flex-column h-100">
        <div class="block-content block-content-full flex-grow-1">
            <div class="item bg-body mx-auto my-2 rounded-3">
                <i class="fa fa-flag-checkered text-success"></i>

            </div>
            <div class="fs-1 fw-bold">{{ $Ticketsclosedtoday ?? 0 }}</div>
            <div class="text-muted mb-3">Tickets Closed Today</div>
        </div>
        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm card-btn-green">
            <a class="fw-medium" href="{{ route('tickets.serviceTickets', ['status' => 'Tickets Closed Today']) }}">
                View Records <i class="fa fa-arrow-right ms-1 opacity-25"></i>
            </a>
        </div>
    </div>
</div>
</div>

    

      

  



</div>


        <!-- END Page Content -->
      </main>
@endsection
