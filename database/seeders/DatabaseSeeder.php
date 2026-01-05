<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\KategoriSkpi;
use App\Models\SubKategoriSkpi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin SKPI',
            'email' => 'admin@skpi.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Program Studi
        $si = ProgramStudi::create([
            'kode' => '4',
            'nama' => 'Sistem Informasi',
            'nama_en' => 'Information Systems',
        ]);

        $if = ProgramStudi::create([
            'kode' => '5',
            'nama' => 'Informatika',
            'nama_en' => 'Informatics',
        ]);

        // Create Dosen
        $dosenSI = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@skpi.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'nip' => '197501012000031001',
            'program_studi_id' => $si->id,
        ]);

        $dosenIF = User::create([
            'name' => 'Dr. Ani Wijaya',
            'email' => 'ani@skpi.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'nip' => '198001012005032001',
            'program_studi_id' => $if->id,
        ]);

        // Assign dosen to program studi
        $si->update(['dosen_id' => $dosenSI->id]);
        $if->update(['dosen_id' => $dosenIF->id]);

        // Create Sample Mahasiswa
        User::create([
            'name' => 'Ramandhika',
            'email' => 'ram@tsu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '20432135',
            'program_studi_id' => $si->id,
        ]);

        User::create([
            'name' => 'Ilham',
            'email' => 'ilham@tsu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '21500027',
            'program_studi_id' => $if->id,
        ]);

        // Create Kategori SKPI
        $kategori1 = KategoriSkpi::create([
            'nama' => 'Prestasi Akademik',
            'nama_en' => 'Academic Achievement',
            'nilai' => 100,
            'deskripsi' => 'Prestasi dalam bidang akademik',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori1->id,
            'nama' => 'Juara Kompetisi Akademik Nasional',
            'nama_en' => 'National Academic Competition Winner',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori1->id,
            'nama' => 'Juara Kompetisi Akademik Internasional',
            'nama_en' => 'International Academic Competition Winner',
        ]);

        $kategori2 = KategoriSkpi::create([
            'nama' => 'Organisasi dan Kepemimpinan',
            'nama_en' => 'Organization and Leadership',
            'nilai' => 80,
            'deskripsi' => 'Kegiatan organisasi dan kepemimpinan',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori2->id,
            'nama' => 'Ketua Organisasi',
            'nama_en' => 'Organization Chairman',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori2->id,
            'nama' => 'Anggota Organisasi',
            'nama_en' => 'Organization Member',
        ]);

        $kategori3 = KategoriSkpi::create([
            'nama' => 'Pengabdian Masyarakat',
            'nama_en' => 'Community Service',
            'nilai' => 60,
            'deskripsi' => 'Kegiatan pengabdian kepada masyarakat',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori3->id,
            'nama' => 'KKN',
            'nama_en' => 'Community Service Program',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori3->id,
            'nama' => 'Volunteer',
            'nama_en' => 'Volunteer Activity',
        ]);
    }
}
