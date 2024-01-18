<?php

namespace Modules\News\database\seeders;

use Illuminate\Database\Seeder;

class NewsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $this->call([LanguageSeeder::class]);
    }
}
