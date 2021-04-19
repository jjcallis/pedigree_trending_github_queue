<?php

namespace App\Jobs;

use App\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Repositories\LanguageColoursRepository;

class ProgrammingLanguageSeeder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private LanguageColoursRepository $colours)
    {
        //
    }

    /**
     * Run the Programming Language database seed.
     *
     * @return int
     */
    public function handle(): int
    {
        Language::query()->insert(
            $this->getLanguages()->map(function ($language) {
                return [
                    'code' => $language['aliases'][0],
                    'name' => $language['name'],
                    'colour' => $this->colours->find($language['aliases'][0]),
                ];
            })->toArray()
        );

        return 0;
    }

    private function getLanguages(): Collection
    {
        $languages = [];

        try {
            $languages = json_decode(
                Http::get("https://api.github.com/languages")->getBody()->getContents(),
                true
            );
        } finally {
            return collect($languages);
        }
    }
}
