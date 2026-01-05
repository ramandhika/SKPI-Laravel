<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategoriSkpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_skpi_id',
        'nama',
        'nama_en',
        'deskripsi',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSkpi::class, 'kategori_skpi_id');
    }

    public function skpiMahasiswa()
    {
        return $this->hasMany(SkpiMahasiswa::class);
    }
}
