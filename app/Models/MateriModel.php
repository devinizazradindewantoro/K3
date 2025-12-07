<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['Kebijakan_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'];

    public function Kebijakan()
    {
        return $this->belongsTo(KebijakanModel::class, 'Kebijakan_id', 'Kebijakan_id');
    }

    public function stok()
    {
        return $this->hasOne(ProsedurModel::class, 'barang_id', 'barang_id');
    }
}