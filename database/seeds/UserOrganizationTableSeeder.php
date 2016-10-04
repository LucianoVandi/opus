<?php

use Carbon\Carbon;
use Faker\Factory;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserOrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $userType = [
            'normal',
            'admin'
        ];
        $users = User::pluck('id')->all();
        $organizations = Organization::pluck('id')->all();

        for ($i = 0; $i < 20; $i++) {
            DB::insert('INSERT INTO user_organization (user_id, user_type, organization_id, created_at, updated_at) values (?, ?, ?, ?, ?)', [
                $faker->randomElement($users),
                $faker->randomElement($userType),
                $faker->randomElement($organizations),
                Carbon::now(),
                Carbon::now(),
            ]);
        }
    }
}