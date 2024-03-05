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
        Schema::table('master_transaction', function (Blueprint $table) {
            $table->foreign(['barang_id'], 'master_transaction_barang_id_index')->references(['id'])->on('master_barang')->onDelete('CASCADE');
            $table->foreign(['cabang_id'], 'master_transaction_cabang_id_index')->references(['id'])->on('master_cabang')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'master_transaction_user_id_index')->references(['id'])->on('master_user')->onDelete('CASCADE');       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_transaction', function (Blueprint $table) {
            $table->dropForeign('master_transaction_barang_id_index');
            $table->dropForeign('master_transaction_cabang_id_index');
            $table->dropForeign('master_transaction_user_id_index');
        });
    }
};
