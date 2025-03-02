<?php

namespace App\Http\Controllers;

use App\Models\Predikat;
use App\Models\ReportCard;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Semester;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ReportCardImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('students')->get();
        return view('reportcard.index', compact('classes'));
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

    /**
     * Show the semesters for a specific student.
     *
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function showSemesters(Student $student)
    {
        $semesters = ReportCard::where('student_id', $student->id)
            ->with('semester', 'schoolClass')
            ->get();

        // For debugging
        Log::info('Showing semesters for student', [
            'student_id' => $student->id,
            'semesters_count' => $semesters->count(),
            'route_name' => 'report-cards.semesters'
        ]);

        return view('reportcard.semesters', compact('student', 'semesters'));
    }

    public function show(Student $student, Semester $semester)
    {
        $reportCard = ReportCard::where('student_id', $student->id)
            ->where('semester_id', $semester->id)
            ->with(['reportDetails.subject', 'schoolClass'])
            ->firstOrFail();
        $predikat = Predikat::all();
        // dd($predikat);
        return view('reportcard.show', compact('reportCard', 'predikat'));
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

    public function classStudents($classId)
    {
        $class = SchoolClass::with('students')->findOrFail($classId);
        return view('reportcard.class-students', compact('class'));
    }

    public function exportClassReportCards($classId)
    {
        $class = SchoolClass::with([
            'homeroomTeacher', // Explicitly include the homeroom teacher
            'students.reportCards' => function ($query) {
                $query->latest();
            },
            'students.reportCards.reportDetails.subject'
        ])->findOrFail($classId);

        // Debug the homeroom teacher info
        Log::info('HomeRoom Teacher', [
            'class_id' => $class->id,
            'teacher_id' => $class->homeroom_teacher_id,
            'teacher' => $class->homeroomTeacher ? $class->homeroomTeacher->name : 'Not found'
        ]);

        $predikat = Predikat::orderBy('nilai_min', 'desc')->get();

        // Pre-calculate predicates for each score
        foreach ($class->students as $student) {
            if ($student->reportCards->isNotEmpty()) {
                foreach ($student->reportCards->first()->reportDetails as $detail) {
                    $detail->knowledgePredicate = Predikat::getPredikatFromNilai($detail->score_knowledge);
                    $detail->skillPredicate = Predikat::getPredikatFromNilai($detail->score_skill);
                }
            }
        }

        $pdf = Pdf::loadView('reportcard.export-pdf', compact('class', 'predikat'));
        return $pdf->download('report-cards-' . $class->name . '.pdf');
    }
}
