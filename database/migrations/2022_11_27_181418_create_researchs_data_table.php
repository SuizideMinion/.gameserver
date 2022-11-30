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
        Schema::create('researchs_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('research_id');
            $table->string('key');
            $table->text('value');
            $table->timestamps();

            $table->foreign('research_id')->references('id')->on('researchs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('researchs_data');
    }
};
