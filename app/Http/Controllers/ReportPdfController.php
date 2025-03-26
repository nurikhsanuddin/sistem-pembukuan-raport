<?php

namespace App\Http\Controllers;

use App\Models\ReportPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportPdfController extends Controller
{
    /**
     * Display a listing of the report PDFs.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pdfs = ReportPdf::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('reportpdf.index', compact('pdfs', 'search'));
    }

    /**
     * Show the form for uploading a new PDF.
     */
    public function showUploadForm()
    {
        return view('reportpdf.upload');
    }

    /**
     * Import/store a newly uploaded PDF file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'required|mimes:pdf', // 10MB max size
        ]);

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.pdf';

            // Store file in storage/app/public/pdfs
            $path = $file->storeAs('pdfs', $fileName, 'public');

            // Create record in database
            ReportPdf::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $path,
                'file_name' => $originalName,
                'file_size' => $file->getSize(),
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('reportpdf.index')
                ->with('success', 'PDF report has been uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload the PDF file.');
    }

    /**
     * Download the specified PDF file.
     */
    public function download(ReportPdf $reportpdf)
    {
        if (Storage::disk('public')->exists($reportpdf->file_path)) {
            return Storage::disk('public')->download($reportpdf->file_path, $reportpdf->file_name);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * View PDF in browser.
     */
    // public function view(ReportPdf $reportpdf)
    // {
    //     if (Storage::disk('public')->exists($reportpdf->file_path)) {
    //         return response()->file(
    //             Storage::disk('public')->path($reportpdf->file_path),
    //             [
    //                 'Content-Type' => 'application/pdf',
    //                 'Content-Disposition' => 'inline; filename="' . $reportpdf->file_name . '"'
    //             ]
    //         );
    //     }

    //     return back()->with('error', 'File not found.');
    // }

    /**
     * Print PDF with automatic print dialog.
     */
    // public function print(ReportPdf $reportpdf)
    // {
    //     if (!Storage::disk('public')->exists($reportpdf->file_path)) {
    //         return back()->with('error', 'File not found.');
    //     }

    //     // Generate file URL for the view
    //     $fileUrl = Storage::disk('public')->url($reportpdf->file_path);
    //     return view('reportpdf.print', compact('reportpdf', 'fileUrl'));
    // }

    /**
     * Remove the specified PDF from storage.
     */
    public function destroy(ReportPdf $reportpdf)
    {
        if (Storage::disk('public')->exists($reportpdf->file_path)) {
            Storage::disk('public')->delete($reportpdf->file_path);
        }

        $reportpdf->delete();

        return redirect()->route('reportpdf.index')
            ->with('success', 'PDF report has been deleted successfully.');
    }
}
