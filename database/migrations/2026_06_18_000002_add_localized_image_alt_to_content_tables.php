<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLocalizedImageAltToContentTables extends Migration
{
    protected array $tables = ['blogs', 'services', 'projects'];

    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('image_alt_ka')->nullable()->after('image');
                $table->string('image_alt_en')->nullable()->after('image_alt_ka');
            });

            if (Schema::hasColumn($table, 'image_alt_name')) {
                DB::table($table)
                    ->whereNotNull('image_alt_name')
                    ->where('image_alt_name', '!=', '')
                    ->update([
                        'image_alt_ka' => DB::raw('image_alt_name'),
                        'image_alt_en' => DB::raw('image_alt_name'),
                    ]);

                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('image_alt_name');
                });
            }
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('image_alt_name')->nullable()->after('image');
            });

            DB::table($table)
                ->whereNotNull('image_alt_ka')
                ->update([
                    'image_alt_name' => DB::raw('image_alt_ka'),
                ]);

            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['image_alt_ka', 'image_alt_en']);
            });
        }
    }
}
