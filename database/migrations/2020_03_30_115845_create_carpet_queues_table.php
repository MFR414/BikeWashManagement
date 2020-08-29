<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarpetQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carpet_queues', function (Blueprint $table) {
            $table->id();
            $table->date('estimation_time')->nullable();
            $table->string('status', 30);
            $table->date('booking_date');
            $table->timestamps();
        });

        Schema::table('carpet_queues', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('carpet_id');
            $table->foreign('carpet_id')->references('id')->on('carpets');
            $table->unsignedBigInteger('worker1_id');
            $table->foreign('worker1_id')->references('id')->on('workers')->nullable();
            $table->unsignedBigInteger('worker2_id');
            $table->foreign('worker2_id')->references('id')->on('workers')->nullable();
            $table->unsignedBigInteger('washtype_id');
            $table->foreign('washtype_id')->references('id')->on('wash_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carpet_queues');
    }
}
