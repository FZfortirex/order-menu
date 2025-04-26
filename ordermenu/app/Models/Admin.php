<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Pastikan kamu menambahkan nama tabel jika tabel admin tidak sesuai dengan default (admin)
    protected $table = 'admin'; // atau sesuaikan dengan nama tabel kamu

    // Menentukan kolom yang bisa diisi
    protected $fillable = ['username', 'password'];

    // Atau jika menggunakan hashing pada password, bisa ditambahkan accessor atau mutator jika perlu
}

