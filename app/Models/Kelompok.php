<?php

// app/Models/Kelompok.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    // Satu Kelompok memiliki banyak User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
