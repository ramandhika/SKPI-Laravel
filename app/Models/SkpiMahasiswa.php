<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpiMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_skpi_id',
        'sub_kategori_skpi_id',
        'nama_kegiatan',
        'nama_kegiatan_en',
        'attachment_url',
        'status',
        'catatan_dosen',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSkpi::class, 'kategori_skpi_id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategoriSkpi::class, 'sub_kategori_skpi_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isSubmitted()
    {
        return $this->status === 'submitted';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
