<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialReceiveItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_receive_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naming_series_id', 10);
            $table->string('code', 50);
            $table->text('description');
            $table->integer('qty_receipt');
            $table->string('unit', 10);
            $table->double('price');
            $table->text('remark');
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
        Schema::dropIfExists('material_receive_items');
    }
}
