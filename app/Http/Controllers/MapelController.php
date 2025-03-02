<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
class MapelController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('mapel.index', compact('subjects'));
    }

    public function edit(Subject $subject)
    {
        return view('mapel.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pengetahuan_A' => 'nullable|string',
            'pengetahuan_B' => 'nullable|string',
            'pengetahuan_C' => 'nullable|string',
            'pengetahuan_D' => 'nullable|string',
            'keterampilan_A' => 'nullable|string',
            'keterampilan_B' => 'nullable|string',
            'keterampilan_C' => 'nullable|string',
            'keterampilan_D' => 'nullable|string',
        ]);

        $subject->update($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus');
    }


}
