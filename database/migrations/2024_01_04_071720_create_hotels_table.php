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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('city');
            $table->string('hotel_name');
            $table->string('embed_code');
            $table->string('landmark');
            $table->string('rating');
            $table->text('Single_image');
            $table->text('multiple_image');
            $table->string('address');
            $table->string('highlights');
            $table->longText('long_decription');
            $table->string('currency');
            $table->text('term_condition');
            $table->string('facilities')->nullable();

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
        Schema::dropIfExists('hotels');
    }
};
