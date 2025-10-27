<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('title', 'Dashboard') - Pravah</title>

    <meta name="description" content="Service Ticket Admin Dashboard">
    <meta name="author" content="Your Name">

    <!-- Icons -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" id="css-main" href="{{ url('assets/css/dashmix.min.css') }}">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @stack('head') <!-- Optional for extra CSS in child blades -->
</head>
<body>
    @include('partials.header')  {{-- Header --}}

<div class="container-fluid dashboard-wrapper">
    @yield('content')
</div>

<style>
/* ✅ Dashboard Layout - Compact & Balanced */

/* Make container fill width with balanced inner padding */
.dashboard-wrapper {
    padding: 0.75rem 1.25rem !important;
    background-color: #f8f9fb; /* optional: subtle background for dashboard look */
}

/* Reduce extra padding inside content area */
.dashboard-wrapper .content {
    padding: 0.5rem 0.75rem !important;
}

/* Ensure rows have consistent gaps (cards won’t combine) */
.dashboard-wrapper .row {
    --bs-gutter-x: 1rem !important; /* horizontal spacing */
    --bs-gutter-y: 1rem !important; /* vertical spacing */
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* Compact card styling */
.dashboard-wrapper .block {
    padding: 0.75rem !important;
    margin-bottom: 0 !important;
}
.dashboard-wrapper .block-content-full {
    padding: 0.75rem !important;
}
.dashboard-wrapper .block-content-sm {
    padding: 0.5rem !important;
}

/* Font and icon adjustments for visual balance */
.dashboard-wrapper .item i {
    font-size: 1.4rem !important;
}
.dashboard-wrapper .fs-1 {
    font-size: 1.1rem !important;
}
.dashboard-wrapper .text-muted.mb-3 {
    font-size: 0.85rem !important;
    margin-bottom: 0.4rem !important;
}

/* ✅ Responsive grid layout */
@media (min-width: 992px) {
    .dashboard-wrapper .col-lg-3 {
        flex: 0 0 23% !important;  /* 4 per row */
        max-width: 23% !important;
    }
}
@media (min-width: 1400px) {
    .dashboard-wrapper .col-lg-3 {
        flex: 0 0 18.5% !important; /* 5 per row */
        max-width: 18.5% !important;
    }
}
</style>


    @include('partials.footer')  {{-- Footer --}}

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Initialize Toastr -->
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>

    @stack('scripts') {{-- Scripts from child blades --}}
  
</body>
</html>

