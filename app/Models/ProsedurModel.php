<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProsedurModel extends Model
{
    use HasFactory;

    protected $table = 't_Prosedur';
    protected $primaryKey = 'Prosedur_id';
    protected $fillable = ['barang_id', 'user_id', 'Prosedur_tanggal', 'Prosedur_jumlah'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(KebijakanModel::class, 'barang_id', 'barang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(InformasiModel::class, 'user_id', 'user_id');
    }
}