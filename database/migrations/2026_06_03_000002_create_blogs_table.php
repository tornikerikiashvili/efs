<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name_ka');
            $table->string('name_en');
            $table->string('slug_ka');
            $table->string('slug_en');
            $table->string('meta_title_ka')->nullable()->default(null);
            $table->string('meta_title_en')->nullable()->default(null);
            $table->longText('meta_description_ka')->nullable()->default(null);
            $table->longText('meta_description_en')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->string('image_alt_name')->nullable()->default(null);
            $table->longText('content_ka')->nullable()->default(null);
            $table->longText('short_content_ka')->nullable()->default(null);
            $table->longText('content_en')->nullable()->default(null);
            $table->longText('short_content_en')->nullable()->default(null);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
