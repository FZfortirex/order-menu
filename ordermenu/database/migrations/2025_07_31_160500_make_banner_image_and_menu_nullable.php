<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->unsignedBigInteger('menu_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
            $table->unsignedBigInteger('menu_id')->nullable(false)->change();
        });
    }
};
