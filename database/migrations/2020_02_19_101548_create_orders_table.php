<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('mall_id')->nullable();
            $table->char('name');
            $table->char('tel');
            $table->text('products');
            $table->decimal('total_money',10,2);
            $table->integer('total_num');
            $table->timestamp('pay_time')->nullable();
            $table->boolean('is_success')->default(0)->comment('确认收货');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
