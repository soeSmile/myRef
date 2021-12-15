<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserToLinks extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('user_to_links', static function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('link_id');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_to_links');
    }
}
