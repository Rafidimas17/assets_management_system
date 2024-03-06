<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\MasterBarang;
use Carbon\Carbon;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  
        public function run()
    {
        // Data yang ingin dimasukkan ke dalam tabel master_role
        $data = [
            ['id'=>1, 'category_id'=>1,'nama' => 'Sepeda Motor', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83246','created_at' => Carbon::now()],
            ['id'=>2,     'category_id'=>2,'nama' => 'Truk Paket','deskripsi'=>'Bagus','kode_barang'=>'IJ83290','created_at' => Carbon::now()],
            ['id'=>3,     'category_id'=>3,'nama' => 'Seragam', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83278','created_at' => Carbon::now()],          
            ['id'=>4,     'category_id'=>4,'nama' => 'Kipas Angin', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83276','created_at' => Carbon::now()],          
            ['id'=>5,     'category_id'=>5,'nama' => 'AC', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83256','created_at' => Carbon::now()],          
            ['id'=>6,     'category_id'=>2,'nama' => 'Kompor', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83234','created_at' => Carbon::now()],          
            ['id'=>7,     'category_id'=>4,'nama' => 'Kulkas', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83223','created_at' => Carbon::now()],          
            ['id'=>8,     'category_id'=>2,'nama' => 'Printer', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83245','created_at' => Carbon::now()],          
            ['id'=>9,     'category_id'=>3,'nama' => 'Scanner', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83267','created_at' => Carbon::now()],          
            ['id'=>10,     'category_id'=>5, 'nama' => 'Kamera', 'deskripsi'=>'Bagus','kode_barang'=>'IJ83269','created_at' => Carbon::now()],                     
        ];

        // Memasukkan data ke dalam tabel master_role
        MasterBarang::insert($data);
    }
      
}
