<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name','50');
            $table->string('last_name','50');
            $table->string('email','100')->unique();
            $table->string('password');
            $table->string('phone_number',20)->nullable();
            $table->string('profile_picture',50)->nullable();
            $table->enum('status', ['active', 'suspended', 'deactivated'])->default('deactivated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
