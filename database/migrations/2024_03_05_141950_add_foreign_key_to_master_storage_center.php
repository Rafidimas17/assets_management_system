<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_center_storage', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'master_center_storage_barang_id_index')->references(['id'])->on('master_barang')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_center_storage', function (Blueprint $table) {
            $table->dropForeign('master_center_storage_barang_id_index');
        });
    }
};
