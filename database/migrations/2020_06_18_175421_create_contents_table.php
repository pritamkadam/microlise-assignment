<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('content_category_id');
            $table->string('title');
            $table->text('file_name')->nullable();
            $table->text('original_file_name')->nullable();
            $table->text('file_path');
            $table->enum('favorite', ['0', '1'])->default('0');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('content_category_id')->references('id')->on('content_category');
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
        Schema::dropIfExists('contents');
    }
}
