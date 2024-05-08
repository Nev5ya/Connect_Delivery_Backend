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
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable(true);
            $table->string('photo')->default('/storage/images/profilePhotos/default-avatar.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('phone');
        Schema::dropIfExists('photo');
    }
};
