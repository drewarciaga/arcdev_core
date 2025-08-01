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
        Schema::create('admin_menu_grids', function (Blueprint $table) {
            $table->id();
            $table->text('layouts');
            $table->unsignedInteger('user_id');
        });

        Schema::create('organizer_menu_grids', function (Blueprint $table) {
            $table->id();
            $table->text('layouts');
            $table->unsignedInteger('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu_grids');
        Schema::dropIfExists('organizer_menu_grids');
    }
};
