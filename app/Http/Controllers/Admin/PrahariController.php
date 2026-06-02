<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prahari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PrahariController extends Controller
{
    public function index()
    {
        $praharis = Prahari::with(['cases', 'challans'])->latest()->paginate(10);
        return view('admin.praharis.index', compact('praharis'));
    }

    public function create()
    {
        return view('admin.praharis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:praharis',
            'phone'          => 'required|unique:praharis',
            'password'       => 'required|min:6',
            'aadhaar_number' => 'nullable|digits:12',
            'bank_account'   => 'nullable|string|max:255',
            'record_date'    => 'nullable|date',
            'image'          => 'nullable|image|max:5120',
            'video'          => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime,video/webm|max:51200',
        ]);

        Prahari::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'status'         => 'active',
            'password'       => Hash::make($request->password),
            'aadhaar_number' => $request->input('aadhaar_number'),
            'bank_account'   => $request->input('bank_account'),
            'record_date'    => $request->input('record_date'),
            'image_path'     => $request->file('image')?->store('praharis/images', 'public'),
            'video_path'     => $request->file('video')?->store('praharis/videos', 'public'),
            'prahari_id'     => 'PRI' . rand(1000, 9999),
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Prahari created successfully!');
    }

    public function edit(Prahari $prahari)
    {
        return view('admin.praharis.edit', compact('prahari'));
    }

    public function update(Request $request, Prahari $prahari)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|unique:praharis,phone,' . $prahari->id,
            'status'         => 'required|in:active,inactive',
            'aadhaar_number' => 'nullable|digits:12',
            'bank_account'   => 'nullable|string|max:255',
            'record_date'    => 'nullable|date',
            'image'          => 'nullable|image|max:5120',
            'video'          => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime,video/webm|max:51200',
        ]);

        $data = $request->only([
            'name', 'phone', 'status', 'aadhaar_number', 'bank_account', 'record_date',
        ]);

        if ($request->hasFile('image')) {
            $this->deletePublicFile($prahari->image_path);
            $data['image_path'] = $request->file('image')->store('praharis/images', 'public');
        }

        if ($request->hasFile('video')) {
            $this->deletePublicFile($prahari->video_path);
            $data['video_path'] = $request->file('video')->store('praharis/videos', 'public');
        }

        $prahari->update($data);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Prahari updated successfully!');
    }

    public function destroy(Prahari $prahari)
    {
        $this->deletePublicFile($prahari->image_path);
        $this->deletePublicFile($prahari->video_path);
        $prahari->delete();
        return redirect()->route('admin.praharis.index')
                         ->with('success', 'Prahari deleted successfully!');
    }

    public function show(Prahari $prahari)
    {
        return view('admin.praharis.show', compact('prahari'));
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
