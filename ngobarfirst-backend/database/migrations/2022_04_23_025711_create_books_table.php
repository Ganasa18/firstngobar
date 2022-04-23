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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title_book')->nullable();
            $table->integer('id_category')->nullable();
            $table->string('writer_category')->nullable();
            $table->string('publisher_category')->nullable();
            $table->year('publisher_at')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('borrowed')->default(0);
            $table->integer('on_booked')->default(0);
            $table->string('image_book', 2048)->default('book-default-cover.jpg');
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
        Schema::dropIfExists('books');
    }
};