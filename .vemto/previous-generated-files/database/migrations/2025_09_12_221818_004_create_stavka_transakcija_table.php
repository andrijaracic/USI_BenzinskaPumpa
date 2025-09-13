<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stavka_transakcija', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('kolicina');

            $table->bigInteger('transakcija_id')->unsigned();

            $table->bigInteger('proizvod_id')->unsigned();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('transakcija_id')
                ->references('id')
                ->on('transakcija')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('proizvod_id')
                ->references('id')
                ->on('proizvod')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stavka_transakcija');
    }
};
