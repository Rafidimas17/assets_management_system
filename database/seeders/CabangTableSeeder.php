<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\MasterCabang;
use Carbon\Carbon;

class CabangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cabangs=[
            ['id'=>1, 'nama_cabang' => 'J&T Express Candi', 'alamat' => 'Jl. Raya Candi, RT.10/RW.3, Candi Jaya, Candi, Sidoarjo Regency, East Java', 'nomor_telepon'=>'9009898764723','created_at'=>Carbon::now()],
            ['id'=>2, 'nama_cabang' => 'J&T Express DP Sedati', 'alamat' => 'Jl. Raya By pass Juanda No.10, Sedati Gede, Kec. Sedati, Kabupaten Sidoarjo, Jawa Timur', 'nomor_telepon'=>'9009898764723','created_at'=>Carbon::now()],
            ['id'=>3, 'nama_cabang' => 'J&T Express Buduran Raya', 'alamat' => 'Tanggulangin, Kabupaten Sidoarjo, Jawa Timur', 'nomor_telepon'=>'9009898764723','created_at'=>Carbon::now()],    
        ];
        MasterCabang::insert($cabangs);
    }
}
