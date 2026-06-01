<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\Prahari;
use Illuminate\Http\Request;

class CasesController extends Controller
{
    public function index()
    {
        $cases = Cases::with(['prahari','challans'])->latest()->paginate(10);
        $praharis = Prahari::where('status', 'active')->get();
        return view('admin.cases.index', compact('cases', 'praharis'));
    }

    public function create()
    {
        $praharis = Prahari::where('status', 'active')->get();
        return view('admin.cases.create', compact('praharis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prahari_id'  => 'required|exists:praharis,id',
            'type'        => 'required|string',
            'location'    => 'required|string',
            'description' => 'required|string',
        ]);

        Cases::create([
            'case_id'     => 'CASE' . rand(10000, 99999),
            'prahari_id'  => $request->prahari_id,
            'type'        => $request->type,
            'location'    => $request->location,
            'description' => $request->description,
            'document'    => $request->file('document')?->store('documents', 'public'),
            'status'      => 'open',
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Case created successfully!');
    }

    public function edit(Cases $case)
    {
        $praharis = Prahari::where('status', 'active')->get();
        return view('admin.cases.edit', compact('case', 'praharis'));
    }

    public function update(Request $request, Cases $case)
    {
        $request->validate([
            'prahari_id'  => 'required|exists:praharis,id',
            'type'        => 'required|string',
            'location'    => 'required|string',
            'description' => 'required|string',
            'status'      => 'required|in:open,in_progress,closed',
        ]);

        $case->update($request->only(['prahari_id', 'type', 'location', 'description', 'status']));

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Case updated successfully!');
    }

    public function destroy(Cases $case)
    {
        $case->delete();
        return redirect()->route('admin.cases.index')
                         ->with('success', 'Case deleted successfully!');
    }

    public function show(Cases $case)
    {
        return view('admin.cases.show', compact('case'));
    }
}
