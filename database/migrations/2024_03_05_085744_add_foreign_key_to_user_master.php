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
        Schema::table('master_user', function (Blueprint $table) {          
            $table->foreign(['role_id'], 'master_user_role_id_index')->references(['id'])->on('master_role')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['cabang_id'], 'master_user_cabang_id_index')->references(['id'])->on('master_cabang')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_user', function (Blueprint $table) {
            $table->dropForeign('master_user_role_id_index');         
            $table->dropForeign('master_user_cabang_id_index');         
        });
    }
};
