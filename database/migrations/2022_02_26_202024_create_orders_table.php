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
            $table->string('name')->nullable()->comment('Наименование заказа');
            $table->string('address')->comment('Адрес доставки');
            $table->string('comment')->comment('Комментарий к доставке');
            $table->date('delivery_date')->comment('Дедлайн');
            $table->unsignedBigInteger('order_status_id')->default(1)->comment('Статус заказа');
            $table->unsignedBigInteger('user_id')->comment('Идентификатор назначенного курьера')->nullable();
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
