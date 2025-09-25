<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'surat_id',
        'ayat_halaman',
        'tanggal',
        'keterangan',
        'juz',
        'staff_id',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Surat
    public function suratRelasi()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    // Relationship to Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}

// \App\Models\Laporan::factory()->create();
