<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('tbl_inv', function (Blueprint $table) {
            DB::statement("ALTER TABLE tbl_inv MODIFY COLUMN currency ENUM('gbp', 'usd', 'sgd', 'idr', 'aud', 'myr', 'vnd', 'jpy', 'cny', 'thb')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_inv', function (Blueprint $table) {
            DB::statement("ALTER TABLE tbl_inv MODIFY COLUMN currency ENUM('gbp', 'usd', 'sgd', 'idr')");
        });
    }
};