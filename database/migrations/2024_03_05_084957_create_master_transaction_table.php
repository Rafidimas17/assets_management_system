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
        Schema::create('master_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->index('barang_id');
            $table->unsignedBigInteger('cabang_id')->index('cabang_id');
            $table->unsignedBigInteger('user_id')->index('user_id');           
            $table->dateTime('tanggal_transaksi');
            $table->enum('status_transaksi', ['pending', 'drafted', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_transaction');
    }
};
