<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\serviceTickets;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Show Login Page
    public function loginpage()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard'); 
        }

        return back()->withErrors([
            'email' => 'Invalid login details.',
        ]);
    }
    
     public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle password update
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('password.change')->with('success', 'Password updated successfully!');
    }

    // Show Dashboard


// public function dashboard()
// {
//     $today = now()->toDateString();

//     $openTickets = serviceTickets::whereNotIn('user_status', [
//         'DOA Confirmed',
//         'Cancel',
//         'Technically completed',
//         'Completed',
//         'Repaired By Vendor'
//     ])->count();

//     $cancellationRequests = serviceTickets::where('user_status', 'Request For Cancellation')->count();

//     $technicallyCompleted = serviceTickets::where('user_status', 'Technically completed')->count();

//     // Visit Pending
//     $visitPending = serviceTickets::where(function ($q) use ($today) {
//         $q->whereIn('user_status', [
//             'Assigned/WIP',
//             'Released to WFM',
//             'In Process',
//             'In Process.',
//             'Part Available'
//         ])
//         ->orWhere(function ($q2) use ($today) {
//             $q2
//                 ->whereDate('deferment_date', '<=', $today);
//         });
//     })->count();

//     // Sent to Vendor
//     $sentToVendor = serviceTickets::where('user_status', 'Sent to Vendor')->count();

//     // Customer Deferment (<= today)
//     $customerDeferment = serviceTickets::whereDate('deferment_date', '<=', $today)
//         ->count();
   
   
//     $noTechnician = serviceTickets::where(function ($q) {
//         $q->whereNull('technician')
//           ->orWhere('technician', '');
//     })->count();    

//     return view('pages.dashboard', compact(
//         'openTickets',
//         'cancellationRequests',
//         'technicallyCompleted',
//         'visitPending',
//         'sentToVendor',
//         'customerDeferment',
//         'noTechnician'
//     ));
// }
public function dashboard()
{
    $today = now()->toDateString();
    $user = auth()->user();
    $userRole = $user->role->role_name ?? null;

    // Common base query for all
    $baseQuery = serviceTickets::query();

    // 🧩 Restrict for Technician role
    if ($userRole === 'technician') {
        // Option 1: If technician name is stored
        $baseQuery->where('technician', $user->id);

        // Option 2: If you store technician_id
        // $baseQuery->where('technician_id', $user->id);
    }

    // -------------------------------
    // 🔹 1. Technician Not Assigned
    // -------------------------------
    $noTechnician = (clone $baseQuery)
        ->whereNull('technician')
        ->whereNotIn('user_status', ['Completed',
            'DOA Confirmed',
            'Cancel',
            'Technically completed',
            'Repaired By Vendor'
        ])
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 2. High Priority – Visit Due
    // -------------------------------
    $highPriority = (clone $baseQuery)
        ->whereIn('user_status', [
            'Accepted',
            'Assigned/WIP',
            'Assigned/WIP Released to WFM',
            'At Customer Site',
            'Begin Journey',
            'Part Available',
            'Request for Out of Policy R&R'
        ])
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 3. Deferment Date Crossed
    // -------------------------------
$defermentCrossed = (clone $baseQuery)
    ->where('user_status', 'customer deferment')
    ->where(function ($q) use ($today) {
        $q->whereDate('deferment_date', '<=', $today)
          ->orWhereNull('deferment_date');
    })
    ->where('site_code', 'TX70')
    ->count();


    // -------------------------------
    // 🔹 4. Visit Done - SBP Action
    // -------------------------------
    $visitDone = (clone $baseQuery)
        ->whereIn('user_status', [
            'Part Not Available',
            'Replacement Approved',
            'Part Pending Rejected'
        ])
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 5. Open Tickets
    // -------------------------------
    $openTickets = (clone $baseQuery)
        ->whereNotIn('user_status', ['Completed',
            'DOA Confirmed',
            'Cancel',
            'Technically completed',
            'Repaired By Vendor'
        ])
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 6. Sent to Vendor
    // -------------------------------
    $sentToVendor = (clone $baseQuery)
        ->where('user_status', 'Sent to Vendor')
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 7. RFC / Backend Cancellation
    // -------------------------------
    $rfcCancellation = (clone $baseQuery)
        ->whereIn('user_status', [
            'Request For Cancellation',
            'Pending'
        ])
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 8. Technically Completed
    // -------------------------------
    $technicallyCompleted = (clone $baseQuery)
        ->where('user_status', 'Technically completed')
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 9. Completed
    // -------------------------------
    $completed = (clone $baseQuery)
        ->whereIn('user_status', [
            'DOA Confirmed',
            'Cancel',
            'Completed',
            'Repaired By Vendor'
        ])
        ->where('site_code', 'TX70')
        ->count();

    // -------------------------------
    // 🔹 10. Transferred (site ≠ TX70)
    // -------------------------------
    $transferred = (clone $baseQuery)
        ->where('site_code', '!=', 'TX70')
        ->count();

$closerequests = (clone $baseQuery)
        ->where('status', '=', 'Close request')
        ->count();

$notClosedPravah = (clone $baseQuery)
    ->whereIn('user_status', ['Technically Completed','DOA Confirmed', 'Cancel', 'Completed', 'Repaired By Vendor'])
    ->whereNotIn('status', ['Close request', 'Closed', 'Cancel'])
    ->count();
$closedTickets = (clone $baseQuery)
    ->where('status', '=', 'Closed')
    ->count();
    
$Ticketsclosedtoday = (clone $baseQuery)
    ->whereIn('user_status', [
        'Completed',
        'DOA Confirmed',
        'Cancel',
        'Technically completed',
        'Repaired By Vendor'
    ])
    ->whereDate('updated_at', now()->toDateString()) // updated today
    ->where('site_code', 'TX70')
    // ->whereColumn('created_at', '!=', 'updated_at') // exclude if both are same
    ->count();

 
    
    
    $live = (clone $baseQuery)
        ->where('status', '=', 'Live')
    ->count();  
       $backend_cancelation = (clone $baseQuery)
        ->where('status', '=', 'Backend cancelation')
    ->count();   
    
        
    // Return to view
    return view('pages.dashboard', compact(
        'noTechnician',
        'highPriority',
        'defermentCrossed',
        'visitDone',
        'openTickets',
        'sentToVendor',
        'rfcCancellation',
        'technicallyCompleted',
        'completed',
        'transferred',
        'closerequests',
        'notClosedPravah',
        'closedTickets',
        'live',
        'backend_cancelation',
        'Ticketsclosedtoday'
    ));
}




    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page');
    }
}

