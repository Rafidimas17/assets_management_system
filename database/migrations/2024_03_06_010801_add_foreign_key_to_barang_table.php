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
        Schema::table('master_barang', function (Blueprint $table) {
            $table->foreign(['category_id'], 'master_barang_category_id_index')->references(['id'])->on('master_category')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_barang', function (Blueprint $table) {
            $table->dropForeign('master_barang_category_id_index');
        });
    }
};
