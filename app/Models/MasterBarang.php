<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_barang';

    protected $fillable = [
        'nama_barang',
        'harga',
        'stok',
    ];

    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->hasMany(MasterTransaction::class, 'barang_id');
    }

    public function center_storage()
    {
        return $this->hasMany(MasterCenterStorage::class, 'barang_id');
    }

    public function office_storage()
    {
        return $this->hasMany(MasterOfficeStorage::class);
    }
}
