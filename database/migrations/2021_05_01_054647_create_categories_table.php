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

        DB::table('categories')->insert([
            ['en' => 'Information Technology', 'ru' => 'Информационные технологии', 'icon' => 'mdi-laptop'],
            ['en' => 'News', 'ru' => 'Новости', 'icon' => 'mdi-newspaper'],
            ['en' => 'Science', 'ru' => 'Наука', 'icon' => 'mdi-atom'],
            ['en' => 'Technology', 'ru' => 'Техника', 'icon' => 'mdi-rocket-launch-outline'],
            ['en' => 'Business', 'ru' => 'Бизнес и Работа', 'icon' => 'mdi-cash-multiple'],
            ['en' => 'Education', 'ru' => 'Образование', 'icon' => 'mdi-head-cog-outline'],
            ['en' => 'Medicine', 'ru' => 'Медицина', 'icon' => 'mdi-medical-bag'],
            ['en' => 'Humor', 'ru' => 'Юмор', 'icon' => 'mdi-emoticon-lol-outline'],
            ['en' => 'Food', 'ru' => 'Еда', 'icon' => 'mdi-silverware-variant'],
            ['en' => 'Hobbies and Leisure', 'ru' => 'Хобби и Досуг', 'icon' => 'mdi-controller-classic'],
            ['en' => 'Music', 'ru' => 'Музыка', 'icon' => 'mdi-headphones'],
            ['en' => 'Cinema', 'ru' => 'Кино', 'icon' => 'mdi-video-vintage'],
            ['en' => 'Travel', 'ru' => 'Путешествия', 'icon' => 'mdi-airplane'],
            ['en' => 'Shopping', 'ru' => 'Покупки', 'icon' => 'mdi-cart'],
            ['en' => 'Housekeeping', 'ru' => 'Домоводство', 'icon' => 'mdi-home-flood'],
            ['en' => 'Animals', 'ru' => 'Животные', 'icon' => 'mdi-dog-side'],
            ['en' => 'Children', 'ru' => 'Дети', 'icon' => 'mdi-baby-carriage'],
            ['en' => 'Religion and Esoteric', 'ru' => 'Религия и Эзотерика', 'icon' => 'mdi-celtic-cross'],
            ['en' => 'Other ', 'ru' => 'Другое', 'icon' => 'mdi-arrow-expand-all'],
            ['en' => 'Building ', 'ru' => 'Строительство', 'icon' => 'mdi-domain'],
        ]);
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
