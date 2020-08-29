<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBikeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('total_disc')->nullable();
            $table->integer('total_pay');
            $table->integer('paid_amount');
            $table->integer('changes')->nullable();
            $table->string('pay_status', 30);
            $table->string('type_of_payment', 30);
            $table->integer('rating')->nullable();
            $table->timestamps();
        });

        Schema::table('bike_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('cust_id');
            $table->foreign('cust_id')->references('id')->on('customers');
            $table->unsignedBigInteger('bike_id');
            $table->foreign('bike_id')->references('id')->on('bikes');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->unsignedBigInteger('worker_id');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts');
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
        Schema::dropIfExists('bike_histories');
    }
}
