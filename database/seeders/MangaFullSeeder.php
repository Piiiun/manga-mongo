<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manga;
use App\Models\Chapter;

class MangaFullSeeder extends Seeder
{
    public function run(): void
    {
        // buat 10 manga
        Manga::factory(10)->create()->each(function ($manga) {

            // buat chapter 5-20 per manga
            $chapterCount = rand(5,20);

            for ($i = 1; $i <= $chapterCount; $i++) {
                Chapter::factory()->create([
                    'manga_id' => $manga->id,
                    'number' => $i,
                    'title' => "Chapter $i",
                ]);
            }
        });

        echo "Seeder Manga + Chapter Selesai!\n";
    }
}
