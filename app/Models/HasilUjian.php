<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian';

    protected $fillable = [
        'user_id',
        'tanggal',
        'juz',
        'staff_id', // nullable
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationship ke User (santri)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship ke Staff (yang menginput)
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
