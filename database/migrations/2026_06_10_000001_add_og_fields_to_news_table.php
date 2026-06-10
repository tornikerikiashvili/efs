<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOgFieldsToNewsTable extends Migration
{
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('og_title_ka')->nullable()->default(null)->after('meta_description_en');
            $table->string('og_title_en')->nullable()->default(null)->after('og_title_ka');
            $table->longText('og_description_ka')->nullable()->default(null)->after('og_title_en');
            $table->longText('og_description_en')->nullable()->default(null)->after('og_description_ka');
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn([
                'og_title_ka',
                'og_title_en',
                'og_description_ka',
                'og_description_en',
            ]);
        });
    }
}
