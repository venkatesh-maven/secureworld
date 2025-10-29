<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Log;
use App\Models\serviceTickets;
use App\Imports\ExpensesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ServiceTicketImport;
use Illuminate\Support\Facades\DB;
use App\Exports\TicketsExport;
use Illuminate\Validation\ValidationException;
use App\Models\ServiceStatus;
class TicketController extends Controller
{
    // Role check for Admin and Manager
    private function checkAccess()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized - You must be logged in.');
        }
    }

    // Display all tickets
    public function index()
    {
        // $this->checkAccess();
        $tickets = Ticket::with('user')->get(); // eager load user
        return view('tickets.index', compact('tickets'));
    }

    // Show form to create a ticket
    public function create()
    {
        // $this->checkAccess();
        $users = User::all(); // fetch all users to assign tickets if needed
        return view('tickets.create', compact('users'));
    }

    // Store new ticket
    public function store(Request $request)
    {
        // $this->checkAccess();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // âœ… Create ticket and assign to $ticket
        $ticket = Ticket::create([
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => Auth::id(),
            'status'      => 'Open', // default status
        ]);

        // âœ… Log the action
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => 'Created Ticket',
            'description'=> 'Ticket ID: '.$ticket->id.' titled: '.$ticket->title,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }

    // Show single ticket
    public function show($id)
    {
        // $this->checkAccess();
        $ticket = Ticket::with('user')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    // Edit ticket
    public function edit($id)
    {
        // $this->checkAccess();
        $ticket = Ticket::findOrFail($id);
        $users = User::all();
 
                             
        return view('tickets.edit', compact('ticket', 'users'));
    }

    // Update ticket
    public function update(Request $request, $id)
    {
        // $this->checkAccess();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|string|in:Open,In Progress,Resolved,Closed',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // âœ… Log the update
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => 'Updated Ticket',
            'description'=> 'Ticket ID: '.$ticket->id.' updated to title: '.$ticket->title.' and status: '.$ticket->status,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully!');
    }

    // Delete ticket
    public function destroy($id)
    {
        // $this->checkAccess();
        $ticket = Ticket::findOrFail($id);

        // âœ… Log before deleting
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => 'Deleted Ticket',
            'description'=> 'Ticket ID: '.$ticket->id.' titled: '.$ticket->title,
        ]);

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
    }
    //serviceMonitor
//   public function serviceTickets(Request $request)
// {
//     $status = $request->query('status'); // open, request_for_cancellation, technically_completed, etc.
//     $today = now()->toDateString();
// $userRole = auth()->user()->role->role_name ?? null;


//     $ticketsQuery = serviceTickets::select(
//         'id','age','item_category','service_id','sold_to_party','mobile','description',
//         DB::raw("DATE_FORMAT(created_on, '%d %b %Y') as created_on"),
//         'user_status','category','product','technician','site_code','call_bifurcation','part_Required',
//         DB::raw("DATE_FORMAT(changed_on, '%d %b %Y') as changed_on"),
//         'call_completion_date','serial_no','brand','sales_office','confirmation_no','transaction_type','status','availability',
//         'higher_level_item','sla','billing','bill_to_party','pr_number','invoice_number','sto_number','so_number',
//         'article_code','address','service_characteristi','product_source','state','city','warranty','deferment_date',
//         'field_category','Comments'
//     );
// if ($userRole === 'technician') {
//     $ticketsQuery->where('technician', auth()->user()->id);
// }
//     // ðŸŸ¢ Apply filters based on 'status' query
//     switch ($status) {
//         case 'open':
//             $ticketsQuery->whereNotIn('user_status', [
//                 'DOA Confirmed',
//                 'Cancel',
//                 'Technically completed',
//                 'Completed',
//                 'Repaired By Vendor'
//             ]);
//             break;

//         case 'request_for_cancellation':
//             $ticketsQuery->where('user_status', 'Request For Cancellation');
//             break;

//         case 'technically_completed':
//             $ticketsQuery->where('user_status', 'Technically completed');
//             break;

//         case 'visit_pending':
//             $ticketsQuery->where(function ($q) use ($today) {
//                 $q->whereIn('user_status', [
//                     'Assigned/WIP',
//                     'Released to WFM',
//                     'In Process',
//                     'In Process.',
//                     'Part Available'
//                 ])
//                 ->orWhere(function ($q2) use ($today) {
//                     $q2
//                         ->whereDate('deferment_date', '<=', $today);
//                 });
//             });
//             break;

//         case 'sent_to_vendor':
//             $ticketsQuery->where('user_status', 'Sent to Vendor');
//             break;

//         case 'customer_deferment':
//             $ticketsQuery
//                 ->whereDate('deferment_date', '<=', $today);
//             break;
//         case 'no_technician':
//             $ticketsQuery->where(function ($q) {
//                 $q->whereNull('technician')
//                   ->orWhere('technician', '')
//                   ->orWhere('technician', ' ');
//             });
//             break;
//     }

//     $tickets = $ticketsQuery->get();

//     return view("tickets.serviceTicket", compact('tickets', 'status'));
// }

public function serviceTickets(Request $request)
{
    $status = $request->query('status'); // open, request_for_cancellation, etc.
    $today = now()->toDateString();
    $user = auth()->user();
    $userRole = $user->role->role_name ?? null;

    // Base query with selected columns
$ticketsQuery = serviceTickets::select(
    'service_tickets.id',
    'service_tickets.age',
    'service_tickets.item_category',
    'service_tickets.service_id',
    'service_tickets.sold_to_party',
    'service_tickets.mobile',
    'service_tickets.order_type',
    'users.name as technician_name', // 👈 Technician Name from users table
    DB::raw("DATE_FORMAT(service_tickets.created_on, '%d %b %Y') as created_on"),
    'service_tickets.user_status',
    'service_tickets.category',
    'service_tickets.product',
    'service_tickets.technician',
    'service_tickets.site_code',
    'service_tickets.call_bifurcation',
    'service_tickets.part_Required',
    DB::raw("DATE_FORMAT(service_tickets.changed_on, '%d %b %Y') as changed_on"),
    'service_tickets.call_completion_date',
    'service_tickets.serial_no',
    'service_tickets.brand',
    'service_tickets.sales_office',
    'service_tickets.confirmation_no',
    'service_tickets.transaction_type',
    'service_tickets.status',
    'service_tickets.availability',
    'service_tickets.higher_level_item',
    'service_tickets.sla',
    'service_tickets.billing',
    'service_tickets.bill_to_party',
    'service_tickets.pr_number',
    'service_tickets.invoice_number',
    'service_tickets.sto_number',
    'service_tickets.so_number',
    'service_tickets.article_code',
    'service_tickets.address',
    'service_tickets.service_characteristi',
    'service_tickets.product_source',
    'service_tickets.state',
    'service_tickets.city',
    'service_tickets.warranty',
    'service_tickets.deferment_date',
    'service_tickets.field_category',
    'service_tickets.Comments',
    'service_tickets.updated_at'
)
->leftJoin('users', 'users.id', '=', 'service_tickets.technician'); // 👈 Join users table to get technician name


    // 🧩 Restrict by Technician role
    if ($userRole === 'technician') {
        $ticketsQuery->where('technician', $user->id);
    }

    // 🔹 Apply status filters (aligned with dashboard)
    switch ($status) {
        case 'no_technician':
            $ticketsQuery->whereNull('technician')
                         
                         ->where('site_code', 'TX70');
            break;

        case 'high_priority':
            $ticketsQuery->whereIn('user_status', [
                'Accepted',
                'Assigned/WIP',
                'Assigned/WIP Released to WFM',
                'At Customer Site',
                'Begin Journey',
                'Part Available',
                'Request for Out of Policy R&R'
            ])->where('site_code', 'TX70');
            break;

        case 'deferment_crossed':
    $ticketsQuery->where('user_status', 'customer deferment')
        ->where(function ($q) use ($today) {
            $q->whereDate('deferment_date', '<=', $today)
              ->orWhereNull('deferment_date');
        })
        ->where('site_code', 'TX70');
    break;


        case 'visit_done':
            $ticketsQuery->whereIn('user_status', [
                'Part Not Available',
                'Replacement Approved',
                'Part Pending Rejected'
            ])->where('site_code', 'TX70');
            break;

        case 'open':
            $ticketsQuery->whereNotIn('user_status', ['Completed',
                'DOA Confirmed',
                'Cancel',
                'Technically completed',
                'Repaired By Vendor'
            ])->where('site_code', 'TX70');
            break;

        case 'sent_to_vendor':
            $ticketsQuery->where('user_status', 'Sent to Vendor')
                         ->where('site_code', 'TX70');
            break;

        case 'rfc_cancellation':
            $ticketsQuery->whereIn('user_status', [
                'Request For Cancellation',
                'Pending'
            ])->where('site_code', 'TX70');
            break;

        case 'technically_completed':
            $ticketsQuery->where('user_status', 'Technically completed')
                         ->where('site_code', 'TX70');
            break;

        case 'completed':
            $ticketsQuery->whereIn('user_status', [
                'DOA Confirmed',
                'Cancel',
                'Completed',
                'Repaired By Vendor'
            ])->where('site_code', 'TX70');
            break;

        case 'transferred':
            $ticketsQuery->where('site_code', '!=', 'TX70');
            break;
            
             case 'closerequests':
            $ticketsQuery->where('status', '=', 'Close request');
            break; 
case 'closed':
    $ticketsQuery->where('status', 'Closed');
    break;
case 'notclosedpravah':
    $ticketsQuery->whereIn('user_status', ['Technically Completed','DOA Confirmed', 'Cancel', 'Completed', 'Repaired By Vendor'])
        ->whereNotIn('status', ['Close request', 'Closed', 'Cancel']);
    break;
   case 'live': 
        $ticketsQuery->
        where('status', '=', 'Live');
        break;
    case 'Backend cancelation': 
       $ticketsQuery->
        where('status', '=', 'Backend cancelation');
    break;  
    
    case 'Tickets Closed Today': 
        $ticketsQuery->whereIn('user_status', ['Completed',
                'DOA Confirmed',
                'Cancel',
                'Technically completed',
                'Repaired By Vendor'
            ])
            ->whereDate('service_tickets.updated_at', now()->toDateString())
            ->where('site_code', 'TX70');
            break;

        default:
            // If no status is passed, just show all tickets (restricted by role)
            if ($userRole !== 'admin') {
                $ticketsQuery->where('site_code', 'TX70');
            }
            break;
    }

    $tickets = $ticketsQuery->get();

    return view('tickets.serviceTicket', compact('tickets', 'status'));
}

public function serviceTicketsimport(Request $request)
{
  

    return view('tickets.serviceimport');
}

// public function export(Request $request)
// {
//     $status = $request->query('status'); // optional: open, request_for_cancellation, technically_completed
//  $today = now()->toDateString();
 
//     $ticketsQuery = serviceTickets::select(
//         'service_id','sold_to_party','age','mobile','description',
//         DB::raw("DATE_FORMAT(created_on, '%d %b %Y') as created_on"),
//         'user_status','category','product','technician','site_code','call_bifurcation','part_Required',
//         DB::raw("DATE_FORMAT(changed_on, '%d %b %Y') as changed_on"),'sla',
//         'field_category','call_completion_date','Comments'
//     );
// $userRole = auth()->user()->role->role_name ?? null;

// if ($userRole === 'technician') {
//     $ticketsQuery->where('technician', auth()->user()->id);
// }
//     // Apply same filters as in table
//     if ($status == 'open') {
//         $ticketsQuery->whereNotIn('user_status', ['DOA Confirmed', 'Cancel', 'Technically completed', 'Completed', 'Repaired By Vendor']);
//     } elseif ($status == 'request_for_cancellation') {
//         $ticketsQuery->where('user_status', 'Request For Cancellation');
//     } elseif ($status == 'technically_completed') {
//         $ticketsQuery->where('user_status', 'Technically completed');
//     }elseif ($status == 'visit_pending') {
//     $ticketsQuery->where(function ($q) use ($today) {
//         $q->whereIn('user_status', [
//             'Assigned/WIP',
//             'Released to WFM',
//             'In Process',
//             'In Process.',
//             'Part Available'
//         ])
//         ->orWhere(function ($q2) use ($today) {
//             $q2
//               ->whereDate('deferment_date', '<=', $today);
//         });
//     });
// } elseif ($status == 'sent_to_vendor') {
//     $ticketsQuery->where('user_status', 'Sent to Vendor');
// } elseif ($status == 'customer_deferment') {
//     $ticketsQuery->where('user_status', 'Customer Deferment')
//                  ->whereDate('deferment_date', '<=', $today);
// } elseif ($status == 'no_technician') {
//     $ticketsQuery->where(function ($q) {
//         $q->whereNull('technician')
//           ->orWhere('technician', '')
//           ->orWhere('technician', ' ');
//     });
// }
    

//     return Excel::download(new TicketsExport($ticketsQuery), 'tickets.xlsx');
// }

public function export(Request $request)
{
    $status = $request->query('status'); // e.g., open, rfc_cancellation, technically_completed, etc.
    $today = now()->toDateString();
    $user = auth()->user();
    $userRole = $user->role->role_name ?? null;

    // Base export query
$ticketsQuery = serviceTickets::select(
    'service_tickets.service_id as Service_ID', // Service ID
    DB::raw("CONCAT(service_tickets.sold_to_party, ' - ', service_tickets.bill_to_party) as Customer_Info"), // Customer Info (example join)
   DB::raw("DATEDIFF(CURDATE(), service_tickets.created_on) as Age"),
    'service_tickets.mobile as Mobile',
    'service_tickets.order_type as Order_Type',
    DB::raw("DATE_FORMAT(service_tickets.created_on, '%d %b %Y') as Created_On"),
    'service_tickets.user_status as User_Status',
    'service_tickets.item_category as Product_Category',
    'service_tickets.product as Product_Description',
    'users.name as Technician', // from users table
    'service_tickets.site_code as Site_Code',
    'service_tickets.call_bifurcation as Call_Bifurcation',
    'service_tickets.part_Required as Part_Required',
    DB::raw("DATE_FORMAT(service_tickets.changed_on, '%d %b %Y') as Changed_On"),
    'service_tickets.sla as SLA',
    'service_tickets.field_category as Field_Team',
    'service_tickets.call_completion_date as Call_Completion_Date',
    'service_tickets.Comments as Comments',
    DB::raw("DATE_FORMAT(service_tickets.updated_at, '%d %b %Y') as Last_Updated_On"),
    'service_tickets.status as Status'
)
->leftJoin('users', 'users.id', '=', 'service_tickets.technician'); // 👈 Join



    // 🧩 Restrict for technician role
    if ($userRole === 'technician') {
        $ticketsQuery->where('technician', $user->id);
    }

    // 🔹 Apply filters (same as dashboard + serviceTickets)
    switch ($status) {
        case 'no_technician':
            $ticketsQuery->whereNull('technician')
                         
                         ->where('site_code', 'TX70');
            break;

        case 'high_priority':
            $ticketsQuery->whereIn('user_status', [
                'Accepted',
                'Assigned/WIP',
                'Assigned/WIP Released to WFM',
                'At Customer Site',
                'Begin Journey',
                'Part Available',
                'Request for Out of Policy R&R'
            ])->where('site_code', 'TX70');
            break;
            

        case 'deferment_crossed':
    $ticketsQuery->where('user_status', 'customer deferment')
        ->where(function ($q) use ($today) {
            $q->whereDate('deferment_date', '<=', $today)
              ->orWhereNull('deferment_date');
        })
        ->where('site_code', 'TX70');
    break;


        case 'visit_done':
            $ticketsQuery->whereIn('user_status', [
                'Part Not Available',
                'Replacement Approved',
                'Part Pending Rejected'
            ])->where('site_code', 'TX70');
            break;

        case 'open':
            $ticketsQuery->whereNotIn('user_status', ['Completed',
                'DOA Confirmed',
                'Cancel',
                'Technically completed',
                'Repaired By Vendor'
            ])->where('site_code', 'TX70');
            break;

        case 'sent_to_vendor':
            $ticketsQuery->where('user_status', 'Sent to Vendor')
                         ->where('site_code', 'TX70');
            break;

        case 'rfc_cancellation':
            $ticketsQuery->whereIn('user_status', [
                'Request For Cancellation',
                'Pending'
            ])->where('site_code', 'TX70');
            break;

        case 'technically_completed':
            $ticketsQuery->where('user_status', 'Technically completed')
                         ->where('site_code', 'TX70');
            break;

        case 'completed':
            $ticketsQuery->whereIn('user_status', [
                'DOA Confirmed',
                'Cancel',
                'Completed',
                'Repaired By Vendor'
            ])->where('site_code', 'TX70');
            break;

        case 'transferred':
            $ticketsQuery->where('site_code', '!=', 'TX70');
            break;
            
         case 'closerequests':
            $ticketsQuery->where('status', '=', 'Close request');
            break;
            
        case 'closed':
    $ticketsQuery->where('status', 'Closed');
    break;
    
case 'notclosedpravah':
    $ticketsQuery->whereIn('user_status', ['Technically Completed','DOA Confirmed', 'Cancel', 'Completed', 'Repaired By Vendor'])
        ->whereNotIn('status', ['Close request', 'Closed', 'Cancel']);
    break;
   case 'live': 
        $ticketsQuery->
        where('status', '=', 'Live');
        break;
    case 'Backend cancelation': 
       $ticketsQuery->
        where('status', '=', 'Backend cancelation');
    break; 
        case 'Tickets Closed Today': 
        $ticketsQuery->whereIn('user_status', ['Completed',
                'DOA Confirmed',
                'Cancel',
                'Technically completed',
                'Repaired By Vendor'
            ])
            ->whereDate('updated_at', now()->toDateString())
            ->where('site_code', 'TX70');
            break;
        default:
            if ($userRole !== 'admin') {
                $ticketsQuery->where('site_code', 'TX70');
            }
            break;
    }

    // 🔽 Export to Excel
    return Excel::download(new TicketsExport($ticketsQuery), 'tickets_' . ($status ?? 'all') . '.xlsx');
}


    //@import serviceMonitor
public function importServiceMonitor(Request $request)
{
    $request->validate([
        'serviceMonitor' => 'required|mimes:csv,txt,xlsx',
        'mode' => 'required|in:insert,edit'
    ], [
        'serviceMonitor.required' => 'Please select a file to upload.',
        'serviceMonitor.mimes'    => 'Only Excel (xlsx) or CSV files are allowed.',
        'mode.required'           => 'Please select an import mode.',
        'mode.in'                 => 'Invalid import mode selected.'
    ]);

    // Determine the mode (insert or edit)
    $mode = $request->input('mode');

    // Perform import based on selected mode
    Excel::import(new ServiceTicketImport($mode), $request->file('serviceMonitor'));

    // Return success message
    return back()->with('success', ucfirst($mode) . ' Service Monitor data imported successfully.');
}

    //@import serviceOrder
public function importServiceOrder(Request $request)
{
    $request->validate([
        'serviceOrder' => 'required|mimes:csv,txt,xlsx',
    ], [
        'serviceOrder.required' => 'Please select a file to upload.',
        'serviceOrder.mimes'    => 'Only Excel (xlsx) or CSV files are allowed.',
    ]);

    // Always run in update mode (for Service Order uploads)
    Excel::import(new ServiceTicketImport('update'), $request->file('serviceOrder'));

    return back()->with('success', 'Service Order data imported successfully (Update Mode).');
}

    



    // Show the edit form
public function serviceedit(ServiceTickets $ticket)
{
    // Get all technicians for dropdowns, etc.
    $technicians = DB::table('users')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->where('roles.role_name', 'technician')
        ->select('users.id', 'users.name')
        ->get();

    // Get all user names in one go (for lookup)
    $userNames = DB::table('users')->pluck('name', 'id')->toArray();

    // Fetch all change history for this ticket
    $histories = $ticket->histories()->with('user')->get();

    // 🧠 Replace technician IDs with names inside each log summary (non-destructive)
    foreach ($histories as $log) {
        if (str_contains($log->summary, 'technician')) {
            // Use regex to extract IDs and replace with names
            $log->summary = preg_replace_callback(
                "/'(\d+)'/", // match anything like '11'
                function ($matches) use ($userNames) {
                    $id = $matches[1];
                    return "'" . ($userNames[$id] ?? $id) . "'";
                },
                $log->summary
            );
        }
    }
       $statuses = ServiceStatus::where('is_active', true)
                             ->orderBy('name')
                             ->get();
    return view('tickets.serviceedit', compact('ticket', 'technicians', 'histories','statuses'));
}



    // Handle form submission
public function serviceupdate(Request $request, ServiceTickets $ticket)
{



    $data = $request->validate([
        'technician'           => 'nullable|string|max:100',
        'site_code'            => 'nullable|string|max:100',
        'deferment_date'       => 'nullable|date',
        'changed_on'           => 'nullable|date',
        'sla'                  => 'nullable|string|max:50',
        'call_completion_date' => 'nullable|date',
        'field_category'       => 'nullable|string|max:50',
        'comments'             => 'required|string|max:500',
        'status'               => 'nullable|string|max:500',
            'part_required'        => 'nullable|required_if:status,Close|string|max:500',
        'purchase_order'       => 'required_if:part_required,Yes|max:100',
        'invoice'              => 'required_if:part_required,Yes|max:100',
        'pod'                  => 'required_if:part_required,Yes|max:100',
        'grn'                  => 'required_if:part_required,Yes|max:100',
        
        'attachments'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);



    // ✅ Handle file upload
    if ($request->hasFile('attachments')) {
        $path = $request->file('attachments')->store('attachments', 'public');
        $data['attachments'] = $path;
    }

    // ✅ Update ticket
    $ticket->update($data);

    return redirect()->route('tickets.serviceedit', $ticket->id)
                     ->with('success', 'Ticket updated successfully!');
}

public function serviceticketsdestroy($id)
{
    $user = auth()->user();

    // ✅ Check role (assuming you have 'role' field in users table)
    if (auth()->user()->role->role_name !== 'superadmin') {
        return redirect()->back()->with('error', 'You are not authorized to delete tickets.');
    }

    $ticket = serviceTickets::findOrFail($id);

    $ticket->delete(); // Soft delete

    return redirect()->back()->with('success', 'Ticket deleted successfully.');
}

//TechnicianList with ticketstatus
public function technicianList(){

    $user = Auth()->user();
    $userRole = $user->role->role_name ?? null;
    $subQuery = DB::table('service_tickets as st')
                ->select(
                    'st.technician',
                    'st.status',
                    DB::raw('COUNT(st.id) as status_count')
                )
                ->groupBy('st.technician', 'st.status');

    $ticketsList = DB::table(DB::raw("({$subQuery->toSql()}) as t"))
            ->mergeBindings($subQuery)
            ->join('users as u', 'u.id', '=', 't.technician')
            ->join('service_statuses as ss', 'ss.name', '=', 't.status');
              if ($userRole === 'technician') {
                $ticketsList->where('u.id', $user->id);
            }
    $ticketsList = $ticketsList->select(
                'u.id as technician_id',
                'u.name as technician_name',
                  DB::raw('SUM(t.status_count) as total'),
                DB::raw("GROUP_CONCAT(CONCAT(ss.name, '-', t.status_count) SEPARATOR ', ') as total_tickets")
            )
            ->groupBy('u.id', 'u.name')
            //dd($ticketsList->toSql());
            ->get();

    $statuses = ServiceStatus::select('id','name')
                                ->where('is_active', true)
                                ->whereNotIN('name',["Closed","Defective Part Return"])
                                ->orderBy('name') 
                                ->get();  
        return view('tickets.technicianTickets',compact('statuses','ticketsList'));
}

//ticketDetails
public function getUserCategoryTickets($technician_id,$cat_id){
    if (strpos($cat_id, '_') !== false) {
        $cat_id = str_replace('_', ' ', $cat_id);
    }
    $tickets = serviceTickets::select('id','service_id','sold_to_party AS customer_info', DB::raw("DATEDIFF(CURDATE(), created_on) as age"),
                                       'mobile','order_type','created_on','user_status','category AS product_category','product as product_description',
                                       'site_code','call_bifurcation','changed_on','sla','field_category AS field_group','deferment_date','call_completion_date',
                                       'comments','updated_at  AS last_updated_on','part_required')
                               ->where('technician',$technician_id)
                               ->where('status',$cat_id)
                               ->get();
                              // dd($tickets->toSql());
    return response()->json($tickets);
}

}



