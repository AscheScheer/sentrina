<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = ['nama'];

    /**
     * Relasi: Satu surat bisa dimiliki oleh banyak laporan setoran.
     */
    public function laporanSetoran()
    {
        return $this->hasMany(Laporan::class, 'surat');
    }
}

// \App\Models\Surat::factory()->create();
