<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mahasiswa')->with('programStudi');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('program_studi')) {
            $query->where('program_studi_id', $request->program_studi);
        }

        $mahasiswas = $query->latest()->paginate(20);
        $programStudis = ProgramStudi::all();

        return view('admin.mahasiswa.index', compact('mahasiswas', 'programStudis'));
    }

    public function create()
    {
        $programStudis = ProgramStudi::all();
        return view('admin.mahasiswa.create', compact('programStudis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|string|unique:users,nim',
            'password' => 'required|string|min:8',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'mahasiswa';

        User::create($validated);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit(User $mahasiswa)
    {
        $programStudis = ProgramStudi::all();
        return view('admin.mahasiswa.edit', compact('mahasiswa', 'programStudis'));
    }

    public function update(Request $request, User $mahasiswa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($mahasiswa->id)],
            'nim' => ['required', 'string', Rule::unique('users')->ignore($mahasiswa->id)],
            'password' => 'nullable|string|min:8',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $mahasiswa->update($validated);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diupdate');
    }

    public function destroy(User $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'csv') {
                $this->importFromCsv($file);
            } else {
                $this->importFromExcel($file);
            }

            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa.index')
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    private function importFromCsv($file)
    {
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            
            User::updateOrCreate(
                ['nim' => $data['nim']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'] ?? '12345678'),
                    'role' => 'mahasiswa',
                    'program_studi_id' => $data['program_studi_id'],
                ]
            );
        }

        fclose($handle);
    }

    private function importFromExcel($file)
    {
        // Untuk implementasi Excel, butuh library PhpSpreadsheet
        // Install dengan: composer require phpoffice/phpspreadsheet
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $header = array_shift($rows);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            
            if (empty($data['nim'])) continue;
            
            User::updateOrCreate(
                ['nim' => $data['nim']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password'] ?? '12345678'),
                    'role' => 'mahasiswa',
                    'program_studi_id' => $data['program_studi_id'],
                ]
            );
        }
    }
}
