<?php

namespace App\Http\Controllers;

use App\Models\Budaya;
use Illuminate\Http\Request;

class BudayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cultures = Budaya::all();
        return view('pages.dashboard.cultures.index', compact('cultures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_budaya' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'provinsi' => 'nullable|string|max:100',
            'koordinat_lat' => 'nullable|string|max:50',
            'koordinat_lng' => 'nullable|string|max:50',
            'video_url' => 'nullable',
        ]);
        Budaya::create($validated);
        return redirect()->route('cultures.index')->with('success', 'Budaya created successfully
.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $budaya = Budaya::with('segments')->findOrFail($id);
        return view('pages.dashboard.cultures.segments', compact('budaya'));
    }

    public function storeSegment(Request $request, $id)
    {
        $validated = $request->validate([
            'judul_segment' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'video_url' => 'nullable|string',
            'teks_narasi' => 'nullable|string',
        ]);

        $validated['id_budaya'] = $id;
        Budaya::findOrFail($id)->segments()->create($validated);
        return redirect()->route('cultures.show', $id)->with('success', 'Segment created successfully.');
    }

    public function updateSegment(Request $request, $id)
    {   
        $validated = $request->validate([
            'judul_segment' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'video_url' => 'nullable|string',
            'teks_narasi' => 'nullable|string',
        ]);
        $segment = Budaya::findOrFail($id)->segments()->findOrFail($request->segment_id);
        $segment->update($validated);
        return redirect()->route('cultures.show', $id)->with('success', 'Segment updated successfully.');
    }

    public function destroySegment($id, $segmentId)
    {
        $segment = Budaya::findOrFail($id)->segments()->findOrFail($segmentId);
        $segment->delete();
        return redirect()->route('cultures.show', $id)->with('success', 'Segment deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_budaya' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'provinsi' => 'nullable|string|max:100',
            'koordinat_lat' => 'nullable|string|max:50',
            'koordinat_lng' => 'nullable|string|max:50',
            'video_url' => 'nullable',
        ]);
        $budaya = Budaya::findOrFail($id);
        $budaya->update($validated);
        return redirect()->route('cultures.index')->with('success', 'Budaya updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $budaya = Budaya::findOrFail($id);
        $budaya->delete();
        return redirect()->route('cultures.index')->with('success', 'Budaya deleted successfully.');
    }
}
