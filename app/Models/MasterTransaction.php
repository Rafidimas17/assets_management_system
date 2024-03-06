<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTransaction extends Model
{
    use HasFactory;
    protected $table = 'master_transaction';
    protected $fillable = ['nama_pemohon','barang_id', 'cabang_id', 'user_id', 'tanggal_transaksi', 'status_transaksi', 'catatan','jumlah_pengajuan','komentar'];

    public function users()
    {
        return $this->belongsTo(MasterUser::class);
    }

    public function barang()
    {
        return $this->belongsTo(MasterBarang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(MasterCabang::class);
    }
    
    public function user()
    {
        return $this->hasMany(MasterUser::class);
    }
    
}