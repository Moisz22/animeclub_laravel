<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterSeenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_seens', function (Blueprint $table) {
            $table->integer('capitulo_visto');
            $table->integer('dia_capitulo_siguiente');
            $table->unsignedBigInteger('chapterable_id');
            $table->string('chapterable_type');
            $table->integer('estado')->default(1);
            $table->primary(['chapterable_id', 'chapterable_type']);
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
        Schema::dropIfExists('chapter_seen');
    }
}
