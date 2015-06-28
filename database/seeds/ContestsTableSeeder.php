<?php
use Illuminate\Database\Seeder;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class ContestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();

        $count = 100;

        $types = ['art', 'dance', 'painting', 'music', 'singing', 'photography',];
        $allowed = ['file:pdf', 'file:doc', 'video,file:mp4', 'audio,file:mp3', 'photo,file:jpeg', 'photo,file:png'];
        $maintainers = \App\User::whereIsMaintainer(true)->lists('id')->toArray();

        while ($count--) {
            $contest = new \App\Contest;

            $contest->name = $fake->sentence(3);
            $contest->contest_type = $fake->randomElement($types);
            $contest->public = $fake->boolean(90);
            $contest->description = $fake->paragraph(10);
            $contest->submission_type = $fake->randomElement($allowed);
            $contest->image = null;
            $contest->bg_color = $fake->hexColor;
            $contest->color = $fake->randomElement(['#000', '#fff']);
            $contest->rules = $fake->paragraph(15);
            $contest->start_date = $fake->dateTime;
            $contest->end_date = $fake->dateTimeBetween($contest->start_date, '2 years');
            $contest->prize = $fake->numberBetween(1000, 100000000);
            $contest->peer_review_enabled = $fake->boolean(80);
            $contest->peer_review_weightage = $contest->peer_review_enabled ? $fake->randomFloat(2, 0.25, 1) : 0;
            $contest->manual_review_enabled = $fake->boolean(30) || !$contest->peer_review_enabled;
            $contest->manual_review_weightage = $contest->manual_review_enabled ? 1 - $contest->peer_review_weightage : null;
            $contest->maintainer_id = $fake->randomElement($maintainers);
            $contest->max_entries = $fake->numberBetween(1, 3);
            $contest->max_iteration = $fake->numberBetween(1, 10);
            $contest->team_entry_enabled = $fake->boolean(10);
            $contest->team_size = $contest->team_entry_enabled ? $fake->numberBetween(2, 10) : null;

            $contest->save();
        }
    }
}