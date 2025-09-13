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
        Schema::table('users', function (Blueprint $table) {
            $table
                ->bigInteger('rola_id')
                ->unsigned()
                ->default(2)
                ->after('profile_photo_path');

            $table
                ->foreign('rola_id')
                ->references('id')
                ->on('rola')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rola_id');

            $table->dropForeign('users_rola_id_foreign');
        });
    }
};
