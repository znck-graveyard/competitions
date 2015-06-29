<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Artisan::call('migrate:refresh');

        foreach ([
                     UsersTableSeeder::class,
                     ContestsTableSeeder::class,
                     EntriesTableSeeder::class,
                 ] as $seeder) {
            $this->call($seeder);
        }
    }

}
