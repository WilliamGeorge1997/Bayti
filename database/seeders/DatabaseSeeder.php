<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\AdminDatabaseSeeder;
// use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminDatabaseSeeder::class,
            // CategoryDatabaseSeeder::class,
        ]);
    }
}
