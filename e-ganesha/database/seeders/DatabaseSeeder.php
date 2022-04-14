<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\{
    BabTableSeeder,
    UserTableSeeder,
    GenderTableSeeder,
    ReligionTableSeeder,
    PermissionTableSeeder
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            PermissionTableSeeder::class,
            ReligionTableSeeder::class,
            GenderTableSeeder::class,
            BabTableSeeder::class
        ]);
    }
}
