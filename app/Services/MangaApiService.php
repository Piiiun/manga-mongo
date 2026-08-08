<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MangaApiService
{
    protected string $baseUrl = 'https://www.sankavollerei.web.id/comic/shinigami';

    /**
     * Get latest mangas for a given page.
     */
    public function getLatest(int $page = 1)
    {
        $url = "{$this->baseUrl}/latest?page={$page}";
        return $this->request($url);
    }

    /**
     * Get popular mangas for a given page.
     */
    public function getPopular(int $page = 1)
    {
        $url = "{$this->baseUrl}/popular?page={$page}";
        return $this->request($url);
    }

    /**
     * Get slider/featured mangas.
     */
    public function getSlider()
    {
        $url = "{$this->baseUrl}/slider/";
        return $this->request($url);
    }

    /**
     * Get recommended mangas for a given page.
     */
    public function getRecommended(int $page = 1)
    {
        $url = "{$this->baseUrl}/recommended?page={$page}";
        return $this->request($url);
    }

    /**
     * Get manga detail by manga_id.
     */
    public function getDetail(string $mangaId)
    {
        $url = "{$this->baseUrl}/detail/{$mangaId}";
        return $this->request($url);
    }

    /**
     * Get chapter list by manga_id.
     */
    public function getChapters(string $mangaId)
    {
        $url = "{$this->baseUrl}/chapters/{$mangaId}";
        return $this->request($url);
    }

    /**
     * Get reader images by manga_id.
     */
    public function getRead(string $mangaId)
    {
        $url = "{$this->baseUrl}/read/{$mangaId}";
        return $this->request($url);
    }

    /**
     * Helper to perform GET request and return JSON decoded response.
     */
    protected function request(string $url)
    {
        $response = Http::get($url);
        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }
}
