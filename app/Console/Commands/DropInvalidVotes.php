<?php

namespace App\Console\Commands;

use App\Entry;
use App\Reviewer;
use App\User;
use Illuminate\Console\Command;

class DropInvalidVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whizz:delete-invalid-votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete not verified votes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ids = User::whereNotNull('verification_code')->lists('id');

        $n = Reviewer::whereIn('user_id', $ids)->delete();

        $this->output->writeln("Deleted {$n} votes.");


        $entries = Entry::all();

        foreach ($entries as $entry) {
            $votes = $entry->reviewers()->count();
            $this->output->writeln("Old votes {$votes}, new votes {$entry->upvotes}");
            $entry->upvotes = $votes;
            $entry->save();
        }

    }
}
