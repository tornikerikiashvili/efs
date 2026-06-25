<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLocalizedImageAltToNewsTable extends Migration
{
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('image_alt_ka')->nullable()->after('image');
            $table->string('image_alt_en')->nullable()->after('image_alt_ka');
        });

        if (Schema::hasColumn('news', 'image_alt_name')) {
            DB::table('news')
                ->whereNotNull('image_alt_name')
                ->where('image_alt_name', '!=', '')
                ->update([
                    'image_alt_ka' => DB::raw('image_alt_name'),
                    'image_alt_en' => DB::raw('image_alt_name'),
                ]);

            Schema::table('news', function (Blueprint $table) {
                $table->dropColumn('image_alt_name');
            });
        }
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('image_alt_name')->nullable()->after('image');
        });

        DB::table('news')
            ->whereNotNull('image_alt_ka')
            ->update([
                'image_alt_name' => DB::raw('image_alt_ka'),
            ]);

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['image_alt_ka', 'image_alt_en']);
        });
    }
}
