<?php

namespace App\Http\Controllers;

use App\Models\HomeroomTeacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class HomeroomTeacherController extends Controller
{
    public function create()
    {
        $classes = SchoolClass::whereDoesntHave('homeroomTeacher')->get();
        $teachers = HomeroomTeacher::with('schoolClass')->get();
        return view('homeroom.create', compact('classes', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:homeroom_teachers,nip',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'class_id' => 'required|exists:classes,id'
        ]);

        $teacher = HomeroomTeacher::create($validated);

        // Update the homeroom_teacher_id in the class table
        $class = SchoolClass::find($request->class_id);
        $class->homeroom_teacher_id = $teacher->id;
        $class->save();

        return redirect()->route('homeroom.create')->with('success', 'Homeroom teacher added successfully!');
    }

    public function edit(HomeroomTeacher $homeroom)
    {
        $classes = SchoolClass::whereDoesntHave('homeroomTeacher')
            ->orWhere('id', $homeroom->class_id)
            ->get();
        return view('homeroom.edit', compact('homeroom', 'classes'));
    }

    public function update(Request $request, HomeroomTeacher $homeroom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:homeroom_teachers,nip,' . $homeroom->id,
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'class_id' => 'required|exists:classes,id'
        ]);

        // If class has changed, clear the previous relationship
        if ($homeroom->class_id != $request->class_id) {
            // Clear the old relationship if exists
            if ($oldClass = SchoolClass::where('homeroom_teacher_id', $homeroom->id)->first()) {
                $oldClass->homeroom_teacher_id = null;
                $oldClass->save();
            }
        }

        $homeroom->update($validated);

        // Update the homeroom_teacher_id in the new class
        $class = SchoolClass::find($request->class_id);
        $class->homeroom_teacher_id = $homeroom->id;
        $class->save();

        return redirect()->route('homeroom.create')->with('success', 'Homeroom teacher updated successfully!');
    }

    public function destroy(HomeroomTeacher $homeroom)
    {
        // Clear the homeroom_teacher_id from class
        if ($class = SchoolClass::where('homeroom_teacher_id', $homeroom->id)->first()) {
            $class->homeroom_teacher_id = null;
            $class->save();
        }

        $homeroom->delete();
        return redirect()->route('homeroom.create')->with('success', 'Homeroom teacher deleted successfully!');
    }
}
