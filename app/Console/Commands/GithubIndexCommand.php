<?php

namespace App\Console\Commands;

use App\Models\Language;
use Illuminate\Console\Command;
use App\Jobs\GitHubTrendingIndex;
use App\Jobs\ProgrammingLanguageSeeder;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\SpokenLanguageRepository;

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
        $spokenLanguages = app(SpokenLanguageRepository::class);
        Language::pluck('code')->each(function ($programmingLanguage) use ($spokenLanguages) {
            $spokenLanguages->all()->each(function ($spokenLanguage) use ($programmingLanguage) {
                dispatch(new GitHubTrendingIndex($programmingLanguage, $spokenLanguage));
            });
        });
    }
}
