@extends('layouts.master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4">Edit Service Ticket - {{ $ticket->service_id }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


<form action="{{ route('tickets.serviceupdate', $ticket->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

<div class="row g-2">

    {{-- 🔹 Read-Only Fields --}}
    @php
        $readonlyFields = [
            'Service ID' => $ticket->service_id,
            'Customer Info' => $ticket->sold_to_party,
            'Age' => \Carbon\Carbon::parse($ticket->created_on)->diffInDays(\Carbon\Carbon::today()) . ' days',

            'Mobile' => $ticket->mobile,
            'Order Type' => $ticket->order_type,
            'Created On' => $ticket->created_on,
            'User Status' => $ticket->user_status,
            'Product Category' => $ticket->category,
            'Product Description' => $ticket->product,
            'Call Bifurcation' => $ticket->call_bifurcation,
            'Serial No' => $ticket->serial_no,
            'Brand' => $ticket->brand,
        ];
    @endphp

    @foreach($readonlyFields as $label => $value)
        <div class="col-md-3">
            <label class="form-label small">{{ $label }}</label>
            <input type="text" class="form-control form-control-sm" value="{{ $value }}" readonly>
        </div>
    @endforeach
</div>

<hr class="my-3">

{{-- 🟢 Editable Fields Section --}}
<div class="row g-2">

<div class="col-md-3">
    <label class="form-label small">Technician</label>

    @php
        $userRole = auth()->user()->role->role_name ?? null; // assuming 'role' relationship exists
    @endphp

    @if(in_array($userRole, ['admin', 'manager', 'superadmin']))
        {{-- Editable dropdown for Admin & Manager --}}
        <select name="technician" class="form-control form-control-sm">
            <option value="">Select Technician</option>
            @foreach($technicians as $tech)
                <option value="{{ $tech->id }}"
                    {{ old('technician', $ticket->technician) == $tech->id ? 'selected' : '' }}>
                    {{ $tech->name }}
                </option>
            @endforeach
        </select>
    @else
        {{-- Read-only (disabled) dropdown for others --}}
        <select class="form-control form-control-sm" disabled>
            @php
                $selectedTech = $technicians->firstWhere('id', old('technician', $ticket->technician));
            @endphp
            <option selected>{{ $selectedTech->name ?? 'N/A' }}</option>
        </select>
        <input type="hidden" name="technician" value="{{ old('technician', $ticket->technician) }}">
    @endif

    @error('technician')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>




    <div class="col-md-3">
        <label class="form-label small">Site Code</label>
        <input type="text" name="site_code" class="form-control form-control-sm"
               value="{{ old('site_code', $ticket->site_code) }}">
        @error('site_code')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">Deferment Date</label>
        <input type="date" name="deferment_date" class="form-control form-control-sm"
               value="{{ old('deferment_date', $ticket->deferment_date) }}">
        @error('deferment_date')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">Changed On</label>
        <input type="date" name="changed_on" class="form-control form-control-sm"
               value="{{ old('changed_on', \Carbon\Carbon::parse($ticket->changed_on)->format('Y-m-d')) }}">
        @error('changed_on')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">SLA</label>
        <input type="text" name="sla" class="form-control form-control-sm"
               value="{{ old('sla', $ticket->sla) }}">
        @error('sla')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">Call Completion Date</label>
        <input type="date" name="call_completion_date" class="form-control form-control-sm"
               value="{{ old('call_completion_date', $ticket->call_completion_date) }}">
        @error('call_completion_date')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">Field Group</label>
        <input type="text" name="field_category" class="form-control form-control-sm"
               value="{{ old('field_category', $ticket->field_category) }}">
        @error('field_category')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label small">Comments</label>
        <textarea name="comments" class="form-control form-control-sm" rows="2">{{ old('comments', $ticket->comments) }}</textarea>
        @error('comments')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

   
<div class="col-md-3">
    <label class="form-label small">Status</label>
    <select name="status" id="status" class="form-control form-control-sm">
        <option value="">-- Select Status --</option>

        @foreach($statuses as $status)
            {{-- Optional: filter out certain statuses for technicians --}}
            @if(auth()->user()->role->role_name === 'technician' && 
                in_array($status->name, ['Backend cancelation', 'Local purchase', 'Closed']))
                @continue
            @endif

            <option value="{{ $status->name }}" 
                {{ old('status', $ticket->status ?? '') == $status->name ? 'selected' : '' }}>
                {{ $status->name }}
            </option>
        @endforeach
    </select>
</div>


<div class="col-md-3" id="partRequiredContainer" style="display: none;">
    <label class="form-label small">Part Required</label>
    <select name="part_required" id="part_required" class="form-control form-control-sm">
        <option value="">Select</option>
        <option value="Yes" {{ old('part_required', $ticket->part_required ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
        <option value="No" {{ old('part_required', $ticket->part_required ?? '') == 'No' ? 'selected' : '' }}>No</option>
    </select>
    @error('part_required')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const partRequiredContainer = document.getElementById('partRequiredContainer');

    function togglePartRequired() {
        if (statusSelect.value === 'Close') {
            partRequiredContainer.style.display = 'block';
        } else {
            partRequiredContainer.style.display = 'none';
            document.getElementById('part_required').value = '';
        }
    }

    // Run on load (to handle edit mode)
    togglePartRequired();

    // Run on change
    statusSelect.addEventListener('change', togglePartRequired);
});
</script>
@endpush


{{-- Extra fields section (hidden by default) --}}
<div class="row g-2 mt-2" id="partDetailsSection" style="display: none;">
    <div class="col-md-3">
        <label class="form-label small">Purchase Order</label>
        <input type="text" name="purchase_order" class="form-control form-control-sm"
               value="{{ old('purchase_order', $ticket->purchase_order ?? '') }}">
                @error('purchase_order')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">Invoice</label>
        <input type="text" name="invoice" class="form-control form-control-sm"
               value="{{ old('invoice', $ticket->invoice ?? '') }}">
                @error('invoice')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">POD</label>
        <input type="text" name="pod" class="form-control form-control-sm"
               value="{{ old('pod', $ticket->pod ?? '') }}">
                @error('pod')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    </div>

    <div class="col-md-3">
        <label class="form-label small">GRN</label>
        <input type="text" name="grn" class="form-control form-control-sm"
               value="{{ old('grn', $ticket->grn ?? '') }}">
                @error('grn')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    </div>
    
        
</div>
    <div class="col-md-3">
    <label class="form-label small">Attachment</label>
    <input type="file" name="attachments" class="form-control form-control-sm">

    {{-- Show existing attachment if available --}}
    @if(!empty($ticket->attachments))
        <div class="mt-2">
            <a href="{{ asset('storage/' . $ticket->attachments) }}" target="_blank" class="text-primary small">
                <i class="bi bi-paperclip"></i> View Attachment
            </a>
        </div>
    @endif

    @error('attachments')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

{{-- JavaScript to toggle extra fields --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const partRequired = document.getElementById('part_required');
    const partDetailsSection = document.getElementById('partDetailsSection');

    function togglePartDetails() {
        if (partRequired.value === 'Yes') {
            partDetailsSection.style.display = 'flex';
        } else {
            partDetailsSection.style.display = 'none';
            // Optionally clear values when "No" is selected
            partDetailsSection.querySelectorAll('input').forEach(input => input.value = '');
        }
    }

    // Trigger on change
    partRequired.addEventListener('change', togglePartDetails);

    // Trigger on page load (for edit mode)
    togglePartDetails();
});
</script>

</div>

{{-- 🔘 Action Buttons --}}
<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary btn-sm">Update Ticket</button>
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
</div>



</form>
{{-- 🔹 Change History --}}
@if(isset($histories) && $histories->count())
<div class="card mt-4 shadow-sm">
    <div class="card-header bg-light fw-bold">
        <i class="fa fa-history me-1 text-muted"></i> Change History
    </div>
    <div class="card-body p-2">
        <table class="table table-sm table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 150px;">Date & Time</th>
                    <th style="width: 150px;">Changed By</th>
                    <th>Changes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $log)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>
                            <div class="small text-muted">
                                {!! nl2br(e($log->summary)) !!}
                            </div>

                            <details class="mt-1">
                                <summary class="small text-primary">View Details</summary>
                                <pre class="small bg-light p-2 mb-0 border rounded">
Previous: {{ json_encode($log->previous, JSON_PRETTY_PRINT) }}
Changes: {{ json_encode($log->changes, JSON_PRETTY_PRINT) }}
                                </pre>
                            </details>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="alert alert-light mt-4 small text-muted">
    <i class="fa fa-info-circle"></i> No change history available for this ticket.
</div>
@endif

</div>
@endsection
