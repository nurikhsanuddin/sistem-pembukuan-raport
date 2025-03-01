<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create()
    {
        $classes = SchoolClass::all();
        return view('classes.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('classes.create')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function destroy(SchoolClass $class)
    {
        try {
            $class->delete();
            return redirect()->route('classes.create')
                ->with('success', 'Kelas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('classes.create')
                ->with('error', 'Gagal menghapus kelas');
        }
    }

    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);

        $class->update($validated);

        return redirect()->route('classes.create')
            ->with('success', 'Kelas berhasil diperbarui');
    }
}
