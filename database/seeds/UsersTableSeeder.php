<?php
use App\User;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class UsersTableSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        $count = $fake->numberBetween(5, 50);
        while ($count--) {
            $user = new User;
            $user->first_name = $fake->firstName;
            $user->last_name = $fake->lastName;
            $user->email = $fake->email;
            $user->gender = $fake->randomElement(['male', 'female', 'other']);
            $user->password = bcrypt('password');
            $user->username = 'user' . $count;
            $user->is_maintainer = $fake->boolean(40);
            $user->date_of_birth = $fake->date('Y-m-d', '-13 years');
            $user->save();
        }
    }
}