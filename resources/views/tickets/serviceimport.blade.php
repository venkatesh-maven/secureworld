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
<div class="content">
    <div class="row g-3 justify-content-center">
        
        <!-- 🔹 Import Service Monitor -->
        <div class="col-md-5 col-sm-6">
            <form action="{{ route('tickets.importServiceMonitor') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="border rounded-3 p-3 shadow-sm bg-white small-form">
                @csrf

                <h6 class="text-center mb-3 text-primary fw-bold">
                    Import Service Monitor
                </h6>

                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-5">
                        <label for="mode" class="form-label fw-semibold mb-1 small">
                            Import Mode <span class="text-danger">*</span>
                        </label>
                        <select name="mode" id="mode" class="form-select form-select-sm" required>
                            <option value="">-- Select Mode --</option>
                            <option value="insert">Capture new</option>
                            <option value="edit">Update</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-5">
                        <label for="serviceMonitor" class="form-label fw-semibold mb-1 small">
                            File <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               id="serviceMonitor" 
                               name="serviceMonitor" 
                               class="form-control form-control-sm" 
                               required 
                               title="Select Import Service Monitor Excel or CSV file">
                    </div>

                    <div class="col-12 col-md-2 text-center text-md-start">
                        <button type="submit" class="btn btn-sm btn-info w-100 fw-semibold mt-2 mt-md-0">
                            <i class="fas fa-upload me-1"></i> Go
                        </button>
                    </div>
                </div>

                <small class="text-muted d-block text-center mt-2" style="font-size: 0.75rem;">
                    (.xlsx, .xls, .csv)
                </small>
            </form>
        </div>

        <!-- 🔹 Import Service Order -->
        <div class="col-md-5 col-sm-6">
            <form action="{{ route('tickets.importServiceOrder') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="border rounded-3 p-3 shadow-sm bg-white small-form">
                @csrf

                <h6 class="text-center mb-3 text-primary fw-bold">
                    Import Service Order
                </h6>

                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-9">
                        <label for="serviceOrder" class="form-label fw-semibold mb-1 small">
                            File <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               id="serviceOrder" 
                               name="serviceOrder" 
                               class="form-control form-control-sm" 
                               required 
                               title="Select Import Service Order Excel or CSV file">
                    </div>

                    <div class="col-12 col-md-3 text-center text-md-start">
                        <button type="submit" class="btn btn-sm btn-info w-100 fw-semibold mt-2 mt-md-0">
                            <i class="fas fa-upload me-1"></i> Go
                        </button>
                    </div>
                </div>

                <small class="text-muted d-block text-center mt-2" style="font-size: 0.75rem;">
                    (.xlsx, .xls, .csv)
                </small>
            </form>
        </div>

    </div>
</div>
@endif



    </div>
</main>
@endSection