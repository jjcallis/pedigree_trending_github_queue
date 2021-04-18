<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProgrammingLanguageSeeder;
use Illuminate\Support\Facades\Artisan;

class GithubIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Begin the indexing of the GitHub trending pages.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->resetTemporaryDatabase();
        $this->queueInitialIndexing();
        return 0;
    }

    private function resetTemporaryDatabase()
    {
        Artisan::call('migrate:fresh');
        dispatch(app(ProgrammingLanguageSeeder::class));
    }

    private function queueInitialIndexing()
    {
        //
    }
}
