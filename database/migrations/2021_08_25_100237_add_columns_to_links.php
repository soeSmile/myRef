<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('links', static function (Blueprint $table) {
            $table->string('type', 10)->default('ref');
            $table->text('body')->nullable();
            $table->text('body_text')->nullable();
        });

        DB::statement('CREATE INDEX tags_body_idx ON links USING gin (body_text gin_trgm_ops)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('links', static function (Blueprint $table) {
            //
        });
    }
}
