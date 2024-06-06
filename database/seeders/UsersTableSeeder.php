<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert with state
        $userCount = max((int)$this->command->ask('How many users would you like?',20),1);
        User::factory()->testUser()->create();

        User::factory($userCount)->create();
    }
}
