<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterCategory;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        // Data yang ingin dimasukkan ke dalam tabel master_role
        $roles = [
            ['id'=>1, 'nama' => 'Kendaraan', 'created_at' => Carbon::now()],
            ['id'=>2, 'nama' => 'Pakaian', 'created_at' => Carbon::now()],
            ['id'=>3, 'nama' => 'ELektronik', 'created_at' => Carbon::now()],          
            ['id'=>4, 'nama' => 'Komputer', 'created_at' => Carbon::now()],          
            ['id'=>5, 'nama' => 'Perabot', 'created_at' => Carbon::now()],          
        ];

        // Memasukkan data ke dalam tabel master_role
        MasterCategory::insert($roles);
    }
}
