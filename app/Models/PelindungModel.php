<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PelindungModel extends Model
{
    use HasFactory;

    protected $table = 't_Pelindung';
    protected $primaryKey = 'Pelindung_id';
    protected $fillable = ['user_id', 'pembeli', 'Pelindung_kode', 'Pelindung_tanggal'];
    protected $casts = ['Pelindung_tanggal' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    public $timestamps = true; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(InformasiModel::class, 'user_id', 'user_id');
    }

    public function PelindungDetail(): HasMany
    {
        return $this->hasMany(PelindungModel::class, 'Pelindung_id', 'Pelindung_id');
    }
}