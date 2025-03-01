<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function create()
    {

        $semesters = Semester::all();

        return view('semesters.create', compact('semesters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|integer|between:1,6',
            'description' => 'required|string|max:255',
        ]);

        Semester::create($validated);

        return redirect()->route('semesters.create')
            ->with('success', 'Semester berhasil ditambahkan');
    }

    public function destroy(Semester $semester)
    {
        try {
            $semester->delete();
            return redirect()->route('semesters.create')
                ->with('success', 'Semester berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('semesters.create')
                ->with('error', 'Gagal menghapus semester');
        }
    }

    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'number' => 'required|integer|between:1,6',
            'description' => 'required|string|max:255',
        ]);

        $semester->update($validated);

        return redirect()->route('semesters.create')
            ->with('success', 'Semester berhasil diperbarui');
    }
}
