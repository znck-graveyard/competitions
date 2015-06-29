<?php

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class EntriesTableSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();

        $count = 3000;
        $contests = \App\Contest::lists('id')->toArray();
        $users = \App\User::all();

        while ($count--) {
            $entry = new \App\Entry;
            $entry->title = implode(' ', (array)$fake->words(5, true));
            $entry->abstract = implode(PHP_EOL, (array)$fake->paragraphs(5, true));
            $entry->contest_id = $fake->randomElement($contests);
            $entry->entryable_type = \App\User::class;
            $users[rand(0, $users->count() - 1)]->entries()->save($entry);
        }
    }
}