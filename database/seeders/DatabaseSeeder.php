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
            'deskripsi' => 'Prestasi dalam bidang akademik dan kompetisi ilmiah',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori1->id,
            'nama' => 'Juara Kompetisi Akademik Nasional',
            'nama_en' => 'National Academic Competition Winner',
            'nilai' => 100,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori1->id,
            'nama' => 'Juara Kompetisi Akademik Internasional',
            'nama_en' => 'International Academic Competition Winner',
            'nilai' => 120,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori1->id,
            'nama' => 'Publikasi Jurnal Internasional',
            'nama_en' => 'International Journal Publication',
            'nilai' => 100,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori1->id,
            'nama' => 'Publikasi Jurnal Nasional',
            'nama_en' => 'National Journal Publication',
            'nilai' => 75,
        ]);

        $kategori2 = KategoriSkpi::create([
            'nama' => 'Organisasi dan Kepemimpinan',
            'nama_en' => 'Organization and Leadership',
            'deskripsi' => 'Kegiatan organisasi, kepemimpinan dan manajemen',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori2->id,
            'nama' => 'Ketua Organisasi Kampus',
            'nama_en' => 'Campus Organization Chairman',
            'nilai' => 85,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori2->id,
            'nama' => 'Wakil Ketua Organisasi',
            'nama_en' => 'Vice Chairman Organization',
            'nilai' => 70,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori2->id,
            'nama' => 'Sekretaris/Bendahara Organisasi',
            'nama_en' => 'Secretary/Treasurer Organization',
            'nilai' => 60,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori2->id,
            'nama' => 'Anggota Inti Organisasi',
            'nama_en' => 'Core Member Organization',
            'nilai' => 50,
        ]);

        $kategori3 = KategoriSkpi::create([
            'nama' => 'Pengabdian Masyarakat',
            'nama_en' => 'Community Service',
            'deskripsi' => 'Kegiatan pengabdian kepada masyarakat dan CSR',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori3->id,
            'nama' => 'Kuliah Kerja Nyata (KKN)',
            'nama_en' => 'Community Service Program (KKN)',
            'nilai' => 80,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori3->id,
            'nama' => 'Program Volunteer Terstruktur',
            'nama_en' => 'Structured Volunteer Program',
            'nilai' => 70,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori3->id,
            'nama' => 'Kegiatan Bakti Sosial',
            'nama_en' => 'Social Service Activity',
            'nilai' => 55,
        ]);

        $kategori4 = KategoriSkpi::create([
            'nama' => 'Kegiatan Penelitian',
            'nama_en' => 'Research Activity',
            'deskripsi' => 'Kegiatan penelitian dan inovasi ilmiah',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori4->id,
            'nama' => 'Penelitian Skripsi/Tugas Akhir',
            'nama_en' => 'Thesis Research',
            'nilai' => 75,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori4->id,
            'nama' => 'Penelitian Independen',
            'nama_en' => 'Independent Research',
            'nilai' => 85,
        ]);

        $kategori5 = KategoriSkpi::create([
            'nama' => 'Soft Skills dan Pengembangan Diri',
            'nama_en' => 'Soft Skills and Personal Development',
            'deskripsi' => 'Program pengembangan keterampilan lunak dan kepribadian',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori5->id,
            'nama' => 'Sertifikat Training Leadership',
            'nama_en' => 'Leadership Training Certificate',
            'nilai' => 60,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori5->id,
            'nama' => 'Sertifikat Keterampilan Komunikasi',
            'nama_en' => 'Communication Skills Certificate',
            'nilai' => 50,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori5->id,
            'nama' => 'Workshop Entrepreneurship',
            'nama_en' => 'Entrepreneurship Workshop',
            'nilai' => 55,
        ]);

        $kategori6 = KategoriSkpi::create([
            'nama' => 'Sertifikasi Profesional',
            'nama_en' => 'Professional Certification',
            'deskripsi' => 'Sertifikasi profesi dan keahlian teknis',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori6->id,
            'nama' => 'Sertifikasi Internasional (TOEFL/IELTS)',
            'nama_en' => 'International Certification (TOEFL/IELTS)',
            'nilai' => 70,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori6->id,
            'nama' => 'Sertifikasi Teknologi (AWS/Azure/GCP)',
            'nama_en' => 'Technology Certification',
            'nilai' => 80,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori6->id,
            'nama' => 'Sertifikasi Bidang Keahlian Lainnya',
            'nama_en' => 'Other Professional Certification',
            'nilai' => 65,
        ]);

        $kategori7 = KategoriSkpi::create([
            'nama' => 'Prestasi Olahraga dan Seni',
            'nama_en' => 'Sports and Arts Achievement',
            'deskripsi' => 'Prestasi dalam bidang olahraga, seni dan budaya',
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori7->id,
            'nama' => 'Juara Kompetisi Olahraga Nasional',
            'nama_en' => 'National Sports Competition Winner',
            'nilai' => 90,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori7->id,
            'nama' => 'Juara Kompetisi Olahraga Internasional',
            'nama_en' => 'International Sports Competition Winner',
            'nilai' => 110,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori7->id,
            'nama' => 'Penghargaan Seni dan Budaya',
            'nama_en' => 'Arts and Culture Award',
            'nilai' => 75,
        ]);

        SubKategoriSkpi::create([
            'kategori_skpi_id' => $kategori7->id,
            'nama' => 'Atlet Serius/Ambil Bagian Liga Profesional',
            'nama_en' => 'Serious Athlete/Professional League Member',
            'nilai' => 95,
        ]);
    }
}
