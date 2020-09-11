<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialRecievesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_receives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parent_po', 10);
            $table->string('naming_series', 10);
            $table->string('supplier', 50);
            $table->string('no_delivery_order', 20);
            $table->string('time_delivery_order', 10);
            $table->date('posting_date');
            $table->time('posting_time');
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
        Schema::dropIfExists('material_recieves');
    }
}
