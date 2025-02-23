<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function create()
    {
        return view('semesters.create');
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
}
