<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id');
            $table->string('name');
            $table->string('video_path');
            $table->timestamps();
            $table->foreign('lecture_id')->references('id')->on('lectures')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
