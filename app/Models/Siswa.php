<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = ['nis', 'foto_siswa', 'nama', 'jenis_kelamin', 'jurusan'];
    protected $table = 'siswa';
    public $timestamps = true;
}
