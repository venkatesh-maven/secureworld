<?php
namespace App\Http\Controllers;

use App\Models\ServiceStatus;
use Illuminate\Http\Request;

class ServiceStatusController extends Controller
{
    public function index()
    {
        $statuses = ServiceStatus::orderBy('id', 'desc')->get();
        return view('admin.service_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.service_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:service_statuses,name',
            'color' => 'nullable|string|max:50',
        ]);

        ServiceStatus::create([
    'name' => $request->name,
    'is_active' => $request->has('is_active') ? 1 : 0, // ✅ converts 'on' → 1 or unchecked → 0
]);


        return redirect()->route('service-statuses.index')
                         ->with('success', 'Status added successfully!');
    }

    public function edit(ServiceStatus $serviceStatus)
    {
        
                             
        return view('admin.service_statuses.edit', compact('serviceStatus'));
    }

    public function update(Request $request, ServiceStatus $serviceStatus)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:service_statuses,name,' . $serviceStatus->id,
            'color' => 'nullable|string|max:50',
        ]);

        $serviceStatus->update([
    'name' => $request->name,
    'is_active' => $request->has('is_active') ? 1 : 0,
]);


        return redirect()->route('service-statuses.index')
                         ->with('success', 'Status updated successfully!');
    }

    public function destroy(ServiceStatus $serviceStatus)
    {
        $serviceStatus->delete();
        return redirect()->route('service-statuses.index')
                         ->with('success', 'Status deleted successfully!');
    }
}
