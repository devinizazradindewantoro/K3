<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\Informasi as Authenticatable; // implementasi class Authenticatable
use Illuminate\Database\Eloquent\Model;

class InformasiModel
{
    use HasFactory;

    protected $table = 'm_Informasi';       // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'Informasi_id'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = ['level_id', 'Informasiname', 'nama', 'password', 'photo_profile'];

    protected $hidden = ['password']; // jangan di tampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash


    /**
     * Relasi ke tabel level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
    * Mendapatkan nama role
    */
    public function getRoleName(): string 
    {
        return $this->level->level_nama;
    }

    /**
    * Cek apakah Informasi memiliki role tertentu
    */
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    /**
     * Mendapatkan kode role
     */
    public function getRole()
    {
        return $this->level->level_kode;
    }
}