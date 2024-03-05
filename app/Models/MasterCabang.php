<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCabang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_cabang';

    protected $fillable = [
        'nama_cabang',
        'alamat',
        'nomor_telepon',
    ];

    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->hasMany(MasterTransaction::class);
    }
    public function office_storage()
    {
        return $this->hasMany(MasterOfficeStorage::class);
    }

    public function users()
    {
        return $this->hasMany(MasterUser::class);
    }

}
