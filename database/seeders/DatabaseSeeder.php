<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BlogPost;
use App\Models\Comment;
use DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if($this->command->confirm('Do you want to refresh the database?')){
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }
        
        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
