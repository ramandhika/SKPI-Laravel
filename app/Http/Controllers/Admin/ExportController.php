<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkpiMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $query = SkpiMahasiswa::with(['user', 'kategori', 'subKategori', 'reviewer']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('program_studi')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('program_studi_id', $request->program_studi);
            });
        }

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama Mahasiswa');
        $sheet->setCellValue('D1', 'Kategori');
        $sheet->setCellValue('E1', 'Sub Kategori');
        $sheet->setCellValue('F1', 'Nilai');
        $sheet->setCellValue('G1', 'Nama Kegiatan');
        $sheet->setCellValue('H1', 'Nama Kegiatan (EN)');
        $sheet->setCellValue('I1', 'Link Attachment');
        $sheet->setCellValue('J1', 'Status');
        $sheet->setCellValue('K1', 'Reviewer');
        $sheet->setCellValue('L1', 'Tanggal Review');

        // Style header
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE0E0E0');

        // Data
        $row = 2;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->user->nim);
            $sheet->setCellValue('C' . $row, $item->user->name);
            $sheet->setCellValue('D' . $row, $item->kategori->nama);
            $sheet->setCellValue('E' . $row, $item->subKategori->nama);
            $sheet->setCellValue('F' . $row, $item->kategori->nilai);
            $sheet->setCellValue('G' . $row, $item->nama_kegiatan);
            $sheet->setCellValue('H' . $row, $item->nama_kegiatan_en);
            $sheet->setCellValue('I' . $row, $item->attachment_url);
            $sheet->setCellValue('J' . $row, ucfirst($item->status));
            $sheet->setCellValue('K' . $row, $item->reviewer ? $item->reviewer->name : '-');
            $sheet->setCellValue('L' . $row, $item->reviewed_at ? $item->reviewed_at->format('d-m-Y H:i') : '-');
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'skpi_export_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function exportPdf(Request $request)
    {
        $query = SkpiMahasiswa::with(['user', 'kategori', 'subKategori', 'reviewer']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('program_studi')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('program_studi_id', $request->program_studi);
            });
        }

        $data = $query->get();

        $pdf = Pdf::loadView('exports.skpi-pdf', compact('data'));
        return $pdf->download('skpi_export_' . date('Y-m-d_His') . '.pdf');
    }

    public function exportMahasiswaExcel()
    {
        $mahasiswas = User::where('role', 'mahasiswa')
            ->with('programStudi')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Program Studi');

        // Style header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE0E0E0');

        // Data
        $row = 2;
        foreach ($mahasiswas as $index => $mahasiswa) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $mahasiswa->nim);
            $sheet->setCellValue('C' . $row, $mahasiswa->name);
            $sheet->setCellValue('D' . $row, $mahasiswa->email);
            $sheet->setCellValue('E' . $row, $mahasiswa->programStudi ? $mahasiswa->programStudi->nama : '-');
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'mahasiswa_export_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
