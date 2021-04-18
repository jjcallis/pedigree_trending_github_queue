<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Repositories\LanguageColoursRepository;

class LanguageSeeder extends Seeder
{
    /** @var \App\Repositories\LanguageColoursRepository */
    private LanguageColoursRepository $colours;

    public function __construct(LanguageColoursRepository $colours)
    {
        $this->colours = $colours;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::query()->delete();
        Language::query()->insert(
            $this->getLanguages()->map(function ($language) {
                return [
                    'code' => $language['aliases'][0],
                    'name' => $language['name'],
                    'colour' => $this->colours->find($language['aliases'][0]),
                ];
            })->toArray()
        );
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
