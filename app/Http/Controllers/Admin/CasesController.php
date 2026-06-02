<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\Prahari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'document'    => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi,webm,pdf|max:20480',
        ]);

        Cases::create([
            'case_id'     => 'CASE' . rand(10000, 99999),
            'prahari_id'  => $request->prahari_id,
            'type'        => $request->type,
            'location'    => $request->location,
            'description' => $request->description,
            'document'    => $request->file('document')?->store('case-media', 'public'),
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
        if ($request->has('status') && ! $request->has('prahari_id')) {
            $request->validate([
                'status' => 'required|in:open,in_progress,closed',
            ]);

            $case->update(['status' => $request->status]);

            return $request->ajax()
                ? response()->json(['success' => true])
                : redirect()->route('admin.cases.index')->with('success', 'Case status updated successfully!');
        }

        $request->validate([
            'prahari_id'  => 'required|exists:praharis,id',
            'type'        => 'required|string',
            'location'    => 'required|string',
            'description' => 'required|string',
            'status'      => 'required|in:open,in_progress,closed',
            'document'    => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi,webm,pdf|max:20480',
        ]);

        $data = $request->only(['prahari_id', 'type', 'location', 'description', 'status']);

        if ($request->hasFile('document')) {
            if ($case->document) {
                Storage::disk('public')->delete($case->document);
            }

            $data['document'] = $request->file('document')->store('case-media', 'public');
        }

        $case->update($data);

        return $request->ajax()
            ? response()->json(['success' => true])
            : redirect()->route('admin.cases.index')->with('success', 'Case updated successfully!');
    }

    public function destroy(Cases $case)
    {
        if ($case->document) {
            Storage::disk('public')->delete($case->document);
        }

        $case->delete();
        return redirect()->route('admin.cases.index')
                         ->with('success', 'Case deleted successfully!');
    }

    public function show(Cases $case)
    {
        return view('admin.cases.show', compact('case'));
    }
}
