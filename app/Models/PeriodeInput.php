<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeriodeInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    public function isActive()
    {
        $now = Carbon::now();
        return $this->is_active && 
               $now->greaterThanOrEqualTo($this->tanggal_mulai) && 
               $now->lessThanOrEqualTo($this->tanggal_selesai);
    }

    public static function hasActivePeriod()
    {
        return self::where('is_active', true)
            ->where('tanggal_mulai', '<=', Carbon::now())
            ->where('tanggal_selesai', '>=', Carbon::now())
            ->exists();
    }
}
