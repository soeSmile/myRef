<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('ru')->unique();
            $table->string('en')->nullable()->unique();
            $table->boolean('active')->default(true);
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        $categories = [
            ['en' => '', 'ru' => 'Новости', 'icon' => 'mdi-newspaper'],
            ['en' => '', 'ru' => 'Наука', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Техника', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Бизнес и Работа', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Образование', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Медицина', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Юмор', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Еда', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Хобби и Досуг', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Музыка', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Кино', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Путешествия', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Покупки', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Домоводство', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Животные', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Дети', 'icon' => 'mdi-home'],
            ['en' => '', 'ru' => 'Религия и Эзотерика', 'icon' => 'mdi-home'],
        ];
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
