<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFielFlagInLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', static function (Blueprint $table) {
            $table->string('flag', 10)
                ->default('privat')
                ->comment('PUBLIC,PRIVAT')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', static function (Blueprint $table) {
            $table->string('flag', 10)
                ->default('new')
                ->comment('NEW,PUBLIC,PRIVAT')
                ->change();
        });
    }
}
