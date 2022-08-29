<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_ukm');
            $table->unsignedBigInteger('id_artikel_kategori');
            $table->string('title', 100);
            $table->string('intro', 100);
            $table->text(' content');
            $table->binary('image_file_data');
            $table->bigInteger('image_file_size');
            $table->string('image_file_name', 100);
            $table->bigInteger('total_hit');
            $table->timestamps();

            
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_ukm')->references('id')->on('ukm')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_artikel_kategori')->references('id')->on('news_kategori')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel');
    }
}