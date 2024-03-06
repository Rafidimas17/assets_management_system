<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_category';

    protected $fillable = [
        'nama',
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = false; // Nonaktifkan penggunaan created_at dan updated_at

    public function barang()
    {
        return $this->hasMany(MasterBarang::class);
    }
}
