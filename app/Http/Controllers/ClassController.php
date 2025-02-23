<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create()
    {
        return view('classes.create');
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
}
