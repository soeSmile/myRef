<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title')->nullable();
            $table->text('desc')->nullable();
            $table->text('url');
            $table->text('img')->nullable();
            $table->integer('category_id')->nullable();
            $table->uuid('user_id');
            $table->tinyInteger('flag')->default(0)->comment('Flag. Def is privat');
            $table->text('comment')->nullable()->comment('User comment');
            $table->tinyInteger('type')->default(0)->comment('Type. Def is ref');
            $table->text('body')->nullable();
            $table->text('body_text')->nullable();
            $table->timestamps();
        });

        DB::statement('CREATE INDEX tags_title_idx ON links USING gin (title gin_trgm_ops)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
