<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterOfficeStorage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'master_office_storage';
    protected $fillable = ['barang_id', 'cabang_id', 'jumlah_stock'];

  

    public function barang()
    {
        return $this->belongsTo(MasterBarang::class);
    }

    public function cabang()
    {
        return $this->belongsTo(MasterCabang::class);
    }
}