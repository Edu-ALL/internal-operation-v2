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
        Schema::table('tbl_agenda_speaker', function (Blueprint $table) {
            $table->unsignedBigInteger('eduf_id')->nullable()->after('partner_prog_id');

            $table->foreign('eduf_id')->references('id')->on('tbl_eduf_lead')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_agenda_speaker', function (Blueprint $table) {
            //
        });
    }
};