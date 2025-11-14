<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Budaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{

    public function index()
    {
        $arsips = Arsip::with('budaya')->orderBy('created_at', 'desc')->get();
        $budayas = Budaya::select('id', 'nama_budaya')->get();

        return view('pages.dashboard.arsip.index', compact('arsips', 'budayas'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_budaya' => 'required|exists:budayas,id',
            'nama_benda' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // maksimal 2MB
        ]);
        if ($request->hasFile('gambar_url')) {
            $path = $request->file('gambar_url')->store('arsip', 'public');
            $validated['gambar_url'] = $path;
        }

        Arsip::create($validated);

        if ($request->has('from_index')) {
            return redirect()->route('arsip.index')->with('success', 'Arsip berhasil ditambahkan.');
        }
        return redirect()->route('cultures.show', $request->id_budaya)->with('success', 'Arsip berhasil ditambahkan.');
    }


    public function update(Request $request, string $id)
    {
        $arsip = Arsip::findOrFail($id);

        $validated = $request->validate([
            'nama_benda' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('gambar_url')) {
            if ($arsip->gambar_url) {
                Storage::disk('public')->delete($arsip->gambar_url);
            }

            $path = $request->file('gambar_url')->store('arsip', 'public');
            $validated['gambar_url'] = $path;
        }

        $arsip->update($validated);

        if ($request->has('from_index')) {
            return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diupdate.');
        }
        return redirect()->route('cultures.show', $arsip->id_budaya)->with('success', 'Arsip berhasil diupdate.');
    }


    public function destroy(string $id)
    {
        $arsip = Arsip::findOrFail($id);
        $id_budaya = $arsip->id_budaya;
        if ($arsip->gambar_url) {
            Storage::disk('public')->delete($arsip->gambar_url);
        }
        $arsip->delete();
        if (request()->has('from_index')) {
            return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus.');
        }
        return redirect()->route('cultures.show', $id_budaya)->with('success', 'Arsip berhasil dihapus.');
    }
}
