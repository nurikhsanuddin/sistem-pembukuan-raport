<?php

namespace App\Http\Controllers;

use App\Models\Predikat;
use App\Models\Semester;
use Illuminate\Http\Request;

class PredikatController extends Controller
{
    public function index()
    {

        $predikats = Predikat::all();

        return view('predikat.create', compact('predikats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nilai_min' => 'required|integer|min:0|max:100',
            'nilai_max' => 'required|integer|min:0|max:100|gte:nilai_min',
            'predikat' => 'required|string|max:255',
            'deskripsi' => 'required|string'
        ]);

        Predikat::create($validated);

        return redirect()->route('predikat.index')
            ->with('success', 'Predikat berhasil ditambahkan');
    }

    public function destroy(Predikat $predikat)
    {
        try {
            $predikat->delete();
            return redirect()->route('predikat.index')
                ->with('success', 'Predikat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('predikat.index')
                ->with('error', 'Gagal menghapus Predikat');
        }
    }

    public function edit(Predikat $predikat)
    {
        // dd($predikat);
        return view('predikat.edit', compact('predikat'));
    }

    public function update(Request $request, Predikat $predikat)
    {
        $validated = $request->validate([
            'nilai_min' => 'required|integer|min:0|max:100',
            'nilai_max' => 'required|integer|min:0|max:100|gte:nilai_min',
            'predikat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $predikat->update($validated);

        return redirect()->route('predikat.index')
            ->with('success', 'Predikat berhasil diperbarui');
    }
}
