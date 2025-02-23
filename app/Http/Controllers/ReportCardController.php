<?php

namespace App\Http\Controllers;

use App\Models\ReportCard;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Semester;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ReportCardImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReportCardController extends Controller
{
    public function index()
    {
        return view('reportcard.index');
    }

    /**
     * Tampilkan form upload file Excel.
     */


    public function showUploadForm()
    {
        $classes = SchoolClass::all();
        $semesters = Semester::all();
        return view('reportcard.upload', compact('classes', 'semesters'));
    }

    /**
     * Proses import file Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'class_id' => 'required|exists:classes,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        try {
            Log::info('Starting import process', [
                'class_id' => $request->input('class_id'),
                'semester_id' => $request->input('semester_id'),
            ]);

            DB::beginTransaction();

            Excel::import(
                new ReportCardImport(
                    $request->input('semester_id'), // Parameter pertama: semester_id
                    $request->input('class_id')     // Parameter kedua: class_id
                ),
                $request->file('file')
            );

            DB::commit();

            Log::info('Import completed successfully');
            return redirect()->back()->with('success', 'File berhasil diimport!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import failed', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Gagal import file: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function getStudents()
    {
        try {
            DB::enableQueryLog();

            // Ubah query untuk mendapatkan data terbaru
            $students = DB::table('students AS s')
                ->select(
                    's.id',
                    's.student_no',
                    's.name',
                    'c.name AS class_name'
                )
                ->join('report_cards AS rc', function ($join) {
                    $join->on('s.id', '=', 'rc.student_id')
                        ->whereRaw('rc.id = (SELECT id FROM report_cards WHERE student_id = s.id ORDER BY created_at DESC LIMIT 1)');
                })
                ->join('classes AS c', 'rc.class_id', '=', 'c.id')
                ->orderBy('s.name')
                ->get();

            Log::info('Query executed:', DB::getQueryLog());
            Log::info('Students found:', ['count' => $students->count()]);

            return response()->json([
                'data' => $students,
                'recordsTotal' => $students->count(),
                'recordsFiltered' => $students->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching students:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => $e->getMessage(),
                'data' => [],
                'recordsTotal' => 0,
                'recordsFiltered' => 0
            ], 500);
        }
    }

    public function showSemesters(Student $student)
    {
        $semesters = ReportCard::where('student_id', $student->id)
            ->with('semester', 'schoolClass')
            ->get();
        // dd($semesters);
        return view('reportcard.semesters', compact('student', 'semesters'));
    }

    public function show(Student $student, Semester $semester)
    {
        $reportCard = ReportCard::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->with(['reportDetails.subject', 'schoolClass'])
            ->firstOrFail();

        return view('reportcard.show', compact('reportCard'));
    }

    public function destroy(ReportCard $reportCard)
    {
        try {
            DB::beginTransaction();

            // Delete related report details first
            $reportCard->reportDetails()->delete();

            // Then delete the report card
            $reportCard->delete();

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
