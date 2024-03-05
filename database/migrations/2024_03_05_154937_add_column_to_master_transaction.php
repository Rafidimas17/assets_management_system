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
            $table->integer('jumlah_pengajuan')->after('status_transaksi');
            $table->text('komentar')->after('catatan')->nullable();
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
            $table->dropColumn('jumlah_pengajuan');
            $table->dropColumn('komentar');
        });
    }
};
