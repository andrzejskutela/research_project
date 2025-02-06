<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $hiddenSeeder = "\\Database\\Seeders\\HiddenSeeder";
        if (class_exists($hiddenSeeder)) {
            $this->call([$hiddenSeeder]);
        }
    }
}
