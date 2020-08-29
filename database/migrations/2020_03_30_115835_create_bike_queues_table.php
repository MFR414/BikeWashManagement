<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBikeQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_queues', function (Blueprint $table) {
            $table->id();
            $table->String('estimation_time',10)->nullable();
            $table->String('status', 30);
            $table->date('booking_date');
            $table->timestamps();
        });

        Schema::table('bike_queues', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->unsignedBigInteger('bike_id');
            $table->foreign('bike_id')->references('id')->on('bikes');
            $table->unsignedBigInteger('worker_id');
            $table->foreign('worker_id')->references('id')->on('workers')->nullable();
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
        Schema::dropIfExists('bike_queues');
    }
}
