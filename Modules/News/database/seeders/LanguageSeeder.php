<?php

namespace Modules\News\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    public $tableName = 'languages';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table($this->tableName)->insert([
            'locale' => 'Ukrainian',
            'prefix' => 'ua',
        ]);

        DB::table($this->tableName)->insert([
            'locale' => 'English',
            'prefix' => 'en',
        ]);

        DB::table($this->tableName)->insert([
            'locale' => 'French',
            'prefix' => 'fr',
        ]);
    }
}
