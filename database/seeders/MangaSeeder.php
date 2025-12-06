<?php

namespace Database\Seeders;

use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Page;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class MangaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa genre dulu
        $genres = [
            ['name' => 'Action', 'slug' => 'action'],
            ['name' => 'Adventure', 'slug' => 'adventure'],
            ['name' => 'Comedy', 'slug' => 'comedy'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Fantasy', 'slug' => 'fantasy'],
            ['name' => 'Romance', 'slug' => 'romance'],
            ['name' => 'Isekai', 'slug' => 'isekai'],
            ['name' => 'Magic', 'slug' => 'magic'],
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['slug' => $genre['slug']], $genre);
        }

        // Buat manga example
        $manga = Manga::create([
            'title' => 'Black Clover',
            'alternative_title' => 'Kara Yonca, Noir Clover, Schwarzer Klee, Trébol Negro, Trevo Negro, Trifoglio Nero, Trifoiul Negru, Черный клевер, कालो तीनपाते विरुवा, ブラッククローバー, 黑色五叶草, 블랙 클로버',
            'description' => 'Manga Black Clover yang dibuat oleh komikus bernama Tabata Yuuki ini bercerita tentang Asta dan Yuno ditinggalkan bersama di gereja yang sama, dan tidak dapat dipisahkan sejak saat itu. Sebagai anak-anak, mereka berjanji bahwa mereka akan bersaing satu sama lain untuk melihat siapa yang akan menjadi Kaisar Magus berikutnya. Namun, saat mereka dewasa, beberapa perbedaan di antara mereka menjadi jelas. Yuno adalah seorang jenius dengan sihir, dengan kekuatan dan kontrol yang luar biasa, sementara Asta tidak dapat menggunakan sihir sama sekali, dan mencoba untuk menutupi kekurangannya dengan melatih secara fisik. Ketika mereka menerima Grimoires pada usia 15 tahun, Yuno mendapatkan buku spektakuler dengan semanggi berdaun empat (kebanyakan orang menerima semanggi berdaun tiga), sementara Asta tidak menerima apa-apa. Namun, ketika Yuno diancam, kebenaran tentang kekuatan Asta terungkap, dia menerima Grimoire semanggi lima daun, "semanggi hitam"! Sekarang kedua sahabat itu sedang menuju dunia luar, keduanya mencari tujuan yang sama!',
            'cover_image' => '/covers/black-clover.jpg',
            'author' => 'Tabata Yuuki',
            'artist' => 'Tabata Yuuki',
            'status' => 'Ongoing',
            'type' => 'Manga',
            'rating' => '8.7',
            'released_at' => 2022,
            'serialization' => 'Shounen',
            'total_chapters' => 386,
            'last_update' => '2025-12-04 15:10:17',
            'views' => 32700,
            'rating' => 9.1,
        ]);

        // Attach genres
        $manga->genres()->attach([
            Genre::where('slug', 'comedy')->first()->id,
            Genre::where('slug', 'fantasy')->first()->id,
            Genre::where('slug', 'adventure')->first()->id,
            Genre::where('slug', 'action')->first()->id,
        ]);

        // Buat beberapa chapter
        for ($i = 1; $i <= 18; $i++) {
            $chapter = Chapter::create([
                'manga_id' => $manga->id,
                'number' => $i,
                'title' => $i == 1 ? 'The Beginning' : ($i == 18 ? 'Latest Chapter' : null),
                'published_at' => now()->subDays(18 - $i),
                'views' => rand(50, 1500),
            ]);

            // Buat beberapa pages untuk setiap chapter
            $pageCount = rand(15, 30);
            for ($p = 1; $p <= $pageCount; $p++) {
                Page::create([
                    'chapter_id' => $chapter->id,
                    'page_number' => $p,
                    'image_path' => "manga/pages/{$manga->slug}/chapter-{$i}/page-{$p}.jpg",
                ]);
            }
        }

        $this->command->info('✅ Manga seeder completed!');
        $this->command->info("   - Created manga: {$manga->title}");
        $this->command->info("   - With 18 chapters");
        $this->command->info("   - And multiple pages per chapter");
    }
}