<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCenterStorage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'master_center_storage';
    protected $fillable = ['barang_id', 'jumlah_stock'];

    public function barang()
    {
        return $this->belongsTo(MasterBarang::class);
    }

   
}