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
}

// \App\Models\Laporan::factory()->create();
