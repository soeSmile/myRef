<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('confirm')->default(false);
            $table->uuid('confirm_key')->nullable()->unique();
            $table->integer('time_zone')->default(3);
            $table->string('role', 10)->default('new');
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'id'         => Uuid::uuid4()->toString(),
                'name'       => 'Admin',
                'email'      => 'admin@test.ru',
                'password'   => bcrypt('njhvjp12'),
                'role'       => 'admin',
                'confirm'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
