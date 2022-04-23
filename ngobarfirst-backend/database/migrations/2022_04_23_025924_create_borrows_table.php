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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->string('no_borrowed')->nullable();
            $table->date('date_borrow')->nullable();
            $table->string('id_booking')->nullable();
            $table->integer('id_user')->nullable();
            $table->date('return_date')->nullable();
            $table->date('date_of_return')->nullable();
            $table->string('status')->default('Pinjam');
            $table->integer('total_penalty')->nullable();
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
        Schema::dropIfExists('borrows');
    }
};