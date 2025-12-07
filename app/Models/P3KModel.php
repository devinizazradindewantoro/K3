<?php
 
 namespace App\Models;
 
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
 class P3KModel extends Model
 {
     use HasFactory;
 
     protected $table = 't_penjualan_detail';
     protected $primaryKey = 'detail_id';
     protected $fillable = ['penjualan_id', 'barang_id', 'harga', 'jumlah'];
 
     public function sales(): BelongsTo
     {
         return $this->belongsTo(P3KModel::class, 'penjualan_id', 'penjualan_id');
     }
 
     public function barang(): BelongsTo
     {
         return $this->belongsTo(KebijakanModel::class, 'barang_id', 'barang_id');
     }
 }