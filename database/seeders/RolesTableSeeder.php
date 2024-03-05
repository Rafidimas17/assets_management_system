<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterRole;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Data yang ingin dimasukkan ke dalam tabel master_role
        $roles = [
            ['id'=>1, 'nama_role' => 'HQ', 'created_at' => Carbon::now()],
            ['id'=>2, 'nama_role' => 'Manager', 'created_at' => Carbon::now()],
            ['id'=>3, 'nama_role' => 'Office', 'created_at' => Carbon::now()],          
        ];

        // Memasukkan data ke dalam tabel master_role
        MasterRole::insert($roles);
    }
}
