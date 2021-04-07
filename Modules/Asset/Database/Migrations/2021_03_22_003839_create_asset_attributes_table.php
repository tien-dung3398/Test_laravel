<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->nullable();
            $table->bigInteger('attribute_id')->nullable();
            $table->bigInteger('attribute_value_id')->nullable();
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
        Schema::dropIfExists('asset_attributes');
    }
}
