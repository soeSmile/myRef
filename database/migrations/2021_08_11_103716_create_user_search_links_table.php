<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSearchLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_search_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->uuid('user_id');
            $table->string('link');
            $table->integer('order')->unsigned()->default(1)->comment('Order show on front');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_search_links');
    }
}
