# SKPI Management System

Sistem manajemen SKPI (Surat Keterangan Pendamang Ijazah) yang dibangun dengan Laravel 12, Tailwind CSS, dan Docker.

## Fitur

### Dashboard Admin

- Manajemen mahasiswa (CRUD + Import CSV/Excel)
- Manajemen kategori dan sub-kategori SKPI dengan nilai
- Manajemen periode input SKPI
- Manajemen program studi dengan assignment dosen
- Export data ke Excel dan PDF
- Dashboard dengan statistik lengkap

### Dashboard Mahasiswa

- Input data SKPI dengan validasi Google Drive link
- Sistem status: Draft, Submit, Accept, Reject
- Helper untuk cek aksesibilitas link Google Drive
- View semua data SKPI yang sudah diinput
- Pilih kategori, sub-kategori, dan lihat nilai

### Dashboard Dosen/Kaprodi

- Review SKPI mahasiswa berdasarkan program studi
- Sistem pengelompokan otomatis berdasarkan 3 digit NIM
  - Contoh: 204xxxxx (kode 4) = Sistem Informasi
  - Contoh: 215xxxxx (kode 5) = Informatika
- Accept/Reject SKPI dengan catatan
- Bulk review untuk multiple SKPI

## Requirements

- Docker & Docker Compose
- PHP 8.3+
- Laravel 12
- SQLite

## Installation

### 1. Clone atau Copy Project

```bash
cd /path/to/skpi-app
```

### 2. Setup dengan Docker

```bash
# Build dan start containers
docker-compose up -d

# Masuk ke container
docker exec -it skpi-app sh

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database file
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed initial data
php artisan db:seed

# Install NPM packages dan compile assets (opsional)
npm install
npm run build

# Exit container
exit
```

### 3. Akses Aplikasi

Buka browser dan akses: `http://localhost:8000`

## Default Users

Setelah seeding, Anda dapat login dengan:

### Admin

- Email: `admin@skpi.ac.id`
- Password: `password`

### Dosen Sistem Informasi

- Email: `budi@skpi.ac.id`
- Password: `password`

### Dosen Informatika

- Email: `ani@skpi.ac.id`
- Password: `password`

### Mahasiswa 1 (Sistem Informasi)

- Email: `ram@student.ac.id`
- Password: `password`
- NIM: `20432135`

### Mahasiswa 2 (Informatika)

- Email: `ilham@student.ac.id`
- Password: `password`
- NIM: `21500027`

## Struktur Database

### Program Studi

- Kode: 3 digit identifier (contoh: "4" untuk SI, "5" untuk IF)
- Nama dan nama English
- Assignment ke dosen pengelola

### Kategori SKPI

- Nama kategori (ID & EN)
- Nilai/angka untuk setiap kategori
- Deskripsi
- Multiple sub-kategori

### SKPI Mahasiswa

- Link ke mahasiswa, kategori, dan sub-kategori
- Nama kegiatan (ID & EN)
- Attachment URL (Google Drive)
- Status: draft, submitted, accepted, rejected
- Catatan dosen
- Review tracking

## Import Mahasiswa

### Format CSV

```csv
name,email,nim,password,program_studi_id
John Doe,john@example.com,20432135,password123,1
```

### Format Excel

Gunakan format yang sama dengan CSV di atas.

## Export Data

Admin dapat export data SKPI dalam format:

- **Excel (.xlsx)**: Semua data dengan filtering
- **PDF**: Report format untuk printing

## Development

### Struktur Folder Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         # Controller admin
│   │   ├── Mahasiswa/     # Controller mahasiswa
│   │   └── Dosen/         # Controller dosen
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/                # Eloquent models
resources/
├── views/
│   ├── admin/            # Views admin
│   ├── mahasiswa/        # Views mahasiswa
│   ├── dosen/            # Views dosen
│   └── layouts/          # Layout templates
routes/
└── web.php              # Route definitions
database/
├── migrations/          # Database migrations
└── seeders/            # Database seeders
```

## Customization

### Menambah Program Studi

1. Login sebagai admin
2. Menu "Program Studi"
3. Klik "Tambah Program Studi"
4. Isi kode (3 digit), nama, dan assign dosen

### Menambah Kategori SKPI

1. Login sebagai admin
2. Menu "Kategori SKPI"
3. Klik "Tambah Kategori"
4. Isi nama, nilai, dan deskripsi
5. Tambah sub-kategori sesuai kebutuhan

### Mengatur Periode Input

1. Login sebagai admin
2. Menu "Periode Input"
3. Klik "Tambah Periode"
4. Set tanggal mulai dan selesai
5. Toggle status aktif

## Troubleshooting

### Database Error

```bash
# Reset database
php artisan migrate:fresh --seed
```

### Permission Error

```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

### Docker Issues

```bash
# Rebuild containers
docker-compose down
docker-compose up -d --build
```

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS
- **Database**: SQLite
- **Container**: Docker
- **Export**: PhpSpreadsheet, DomPDF

## License

MIT License

## Support

Untuk pertanyaan atau issues, silakan buat issue di repository ini.
