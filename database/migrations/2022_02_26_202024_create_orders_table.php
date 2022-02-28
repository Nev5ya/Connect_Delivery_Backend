<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('address')->comment('Адрес доставки');
            $table->string('order_comment')->comment('Комментарий к доставке');
            $table->unsignedTinyInteger('order_status')->comment('Статус заказа')->default(0);
            $table->date('delivery_date')->comment('Дедлайн');
            $table->unsignedBigInteger('user_id')->comment('Идентификатор назначенного курьера')->default(0);
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
};
