<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarcodeRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcode_rows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('quantity_used')->nullable();
            $table->bigInteger('category_id')->nullable();
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
        Schema::dropIfExists('barcode_rows');
    }
}
