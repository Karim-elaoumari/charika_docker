<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\JobSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\IndustrySeeder;

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
            IndustrySeeder::class,
            RoleSeeder::class,
            JobSeeder::class,
            CompanySeeder::class,
            ReviewSeeder::class,
            CommentSeeder::class,
        ]);   
    }
}
