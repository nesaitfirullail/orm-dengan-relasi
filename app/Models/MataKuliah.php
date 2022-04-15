<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\Mahasiswa_Matakuliah;

class MataKuliah extends Model
{
    use HasFactory;
    protected $table = 'matakuliah';

    public function mahasiswa(){
        return $this->belongsToMany(Mahasiswa::class);
    }
}
