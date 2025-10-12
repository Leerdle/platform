<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateExercises extends Command
{
    /**
     * @var string
     */
    protected $signature = 'create:exercises';

    /**
     * @var string
     */
    protected $description = 'Create a list of exercises';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Starting batch exercise creation...');

        $this->call('create:exercise', [
            'lang' => 'NL',
            'type' => 'GAP_ATTACK',
            'subject' => 'IMPERFECT_TENSE'
        ]);

        $this->info('Batch exercise creation complete...');
    }
}
