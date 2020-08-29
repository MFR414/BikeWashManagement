<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWashTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wash_type', function (Blueprint $table) {
            $table->id();
            $table->string('wash_type',30);
            $table->String('type_of_goods',50);
            $table->String('type_of_bike',50)->nullable();
            $table->String('size_of_bike',50)->nullable();
            $table->String('type_of_carpets',10)->nullable();
            $table->String('price_per_meter',10)->default(0)->nullable();
            $table->integer('price')->default(0)->nullable();
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
        Schema::dropIfExists('wash_type');
    }
}
