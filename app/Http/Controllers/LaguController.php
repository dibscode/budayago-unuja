<?php

namespace App\Http\Controllers;

use App\Models\Budaya;
use App\Models\Lagu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaguController extends Controller
{
    public function index()
    {
        $lagus = Lagu::with('budaya')->orderBy('created_at', 'desc')->get();
        $budayas = Budaya::select('id', 'nama_budaya')->get();

        return view('pages.dashboard.lagu.index', compact('lagus', 'budayas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_budaya' => 'required|exists:budayas,id',
            'judul_lagu' => 'required|string|max:255',
            'audio_url' => 'nullable|file|mimes:mp3,wav,m4a|max:10240', // maksimal 10MB
            'lirik' => 'nullable|string',
            'arti' => 'nullable|string',
        ]);

        if ($request->hasFile('audio_url')) {
            $path = $request->file('audio_url')->store('lagu', 'public');
            $validated['audio_url'] = $path;
        }

        Lagu::create($validated);

        if ($request->has('from_index')) {
            return redirect()->route('lagu.index')->with('success', 'Lagu berhasil ditambahkan.');
        }

        return redirect()->route('cultures.show', $request->id_budaya)->with('success', 'Lagu berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $lagu = Lagu::findOrFail($id);
        
        $validated = $request->validate([
            'judul_lagu' => 'required|string|max:255',
            'audio_url' => 'nullable|file|mimes:mp3,wav,m4a|max:10240',
            'lirik' => 'nullable|string',
            'arti' => 'nullable|string',
        ]);

        if ($request->hasFile('audio_url')) {
            if ($lagu->audio_url) {
                Storage::disk('public')->delete($lagu->audio_url);
            }
            $path = $request->file('audio_url')->store('lagu', 'public');
            $validated['audio_url'] = $path;
        }

        $lagu->update($validated);

        if ($request->has('from_index')) {
             return redirect()->route('lagu.index')->with('success', 'Lagu berhasil diupdate.');
        }

        return redirect()->route('cultures.show', $lagu->id_budaya)->with('success', 'Lagu berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $lagu = Lagu::findOrFail($id);
        $id_budaya = $lagu->id_budaya;

        if ($lagu->audio_url) {
            Storage::disk('public')->delete($lagu->audio_url);
        }

        $lagu->delete();

        if (request()->has('from_index')) {
            return redirect()->route('lagu.index')->with('success', 'Lagu berhasil dihapus.');
        }

        return redirect()->route('cultures.show', $id_budaya)->with('success', 'Lagu berhasil dihapus.');
    }
}
