<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRole extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_role';

    protected $fillable = [
        'nama_role',
    ];

    protected $dates = ['deleted_at'];
    public function users(){
        $this->hasMany(MasterUsers::class);
    }
}
