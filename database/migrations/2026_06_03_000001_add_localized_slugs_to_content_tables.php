<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddLocalizedSlugsToContentTables extends Migration
{
    protected array $tables = ['news', 'services', 'projects'];

    public function up()
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                if (! Schema::hasColumn($table, 'slug_ka')) {
                    $blueprint->string('slug_ka')->nullable()->after('name_en');
                }
                if (! Schema::hasColumn($table, 'slug_en')) {
                    $blueprint->string('slug_en')->nullable()->after('slug_ka');
                }
            });

            if (Schema::hasColumn($table, 'slug')) {
                $rows = DB::table($table)->get();
                foreach ($rows as $row) {
                    $slugKa = $row->slug ?? $this->makeSlug($row->name_ka ?? '');
                    $slugEn = $this->makeSlug($row->name_en ?? '') ?: ($slugKa ? $slugKa . '-en' : 'item-' . $row->id);

                    DB::table($table)->where('id', $row->id)->update([
                        'slug_ka' => $slugKa ?: 'item-' . $row->id,
                        'slug_en' => $slugEn,
                    ]);
                }

                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('slug');
                });
            }
        }
    }

    private function makeSlug(string $text): string
    {
        $slug = Str::slug($text);

        if ($slug !== '') {
            return $slug;
        }

        $slug = mb_strtolower(trim(preg_replace('/[^\p{L}\p{N}]+/u', '-', $text), '-'));

        return $slug;
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->string('slug')->nullable();
            });

            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                DB::table($table)->where('id', $row->id)->update([
                    'slug' => $row->slug_ka ?? Str::slug($row->name_ka ?? ''),
                ]);
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn(['slug_ka', 'slug_en']);
            });
        }
    }
}
