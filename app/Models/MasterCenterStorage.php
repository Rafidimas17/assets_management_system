<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCenterStorage extends Model
{
    use HasFactory;
    protected $table = 'master_center_storage';
    protected $fillable = ['barang_id', 'jumlah_stock'];

    public function barang()
    {
        return $this->belongsTo(MasterBarang::class);
    }

   
}