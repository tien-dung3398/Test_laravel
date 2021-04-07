<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLifeAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('life_asset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('asset_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('lifeassetable_id')->nullable();
            $table->string('lifeassetable_type')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('life_asset');
    }
}
