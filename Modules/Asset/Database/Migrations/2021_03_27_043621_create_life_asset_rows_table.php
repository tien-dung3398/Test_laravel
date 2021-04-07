<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLifeAssetRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('life_asset_rows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('life_asset_id')->nullable();
            $table->string('value_before')->nullable();
            $table->string('value_after')->nullable();
            $table->integer('lifeassetrowable_id')->nullable();
            $table->string('lifeassetrowable_type')->nullable();
            $table->string('name_property')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('life_asset_rows');
    }
}
