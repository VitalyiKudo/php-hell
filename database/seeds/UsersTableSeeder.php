<?php

use App\User;
use App\Models\Administrator;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create administartor accounts
        factory(Administrator::class)->create([
            'email' => 'demo@junity.dev',
        ]);

        factory(Administrator::class)->create([
            'email' => 'demo@jetonset.com',
        ]);

        // Create users accounts
        factory(User::class)->create([
            'email' => 'demo@junity.dev',
        ]);

        factory(User::class)->create([
            'email' => 'demo@jetonset.com',
        ]);

        factory(User::class, 25)->create();
    }
}
