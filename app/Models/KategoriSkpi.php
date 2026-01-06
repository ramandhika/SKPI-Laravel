<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSkpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nama_en',
        'deskripsi',
    ];

    public function subKategori()
    {
        return $this->hasMany(SubKategoriSkpi::class);
    }

    public function skpiMahasiswa()
    {
        return $this->hasMany(SkpiMahasiswa::class);
    }
}
