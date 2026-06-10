<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->id();
            $table->string('name_ka')->nullable()->default(null);
            $table->string('name_en')->nullable()->default(null);
            $table->string('type')->nullable()->default(null);
            $table->string('alt_name')->nullable()->default(null);
            $table->string('link')->nullable()->default(null);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort')->nullable()->default(null);

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
        Schema::dropIfExists('slider');
    }
}
