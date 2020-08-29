<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarpetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carpets', function (Blueprint $table) {
            $table->id();
            $table->String('color_of_carpet',50);
            $table->String('type_of_carpet',10);
            $table->String('length_of_carpets',10);
            $table->String('width_of_carpets',10);
            $table->integer('amount_of_wash')->default('0')->nullable();
            $table->String('note',100)->nullable();
            $table->timestamps();
        });

        Schema::table('carpets', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carpets');
    }
}
