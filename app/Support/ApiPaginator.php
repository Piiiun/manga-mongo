<?php

namespace App\Support;

use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Support\Collection;

/**
 * Custom paginator untuk data API Shinigami.
 *
 * Mengimplementasikan interface yang kompatibel dengan Blade
 * pagination controls (hasPages, onFirstPage, hasMorePages,
 * currentPage, lastPage, appends, previousPageUrl, nextPageUrl, url).
 *
 * Juga iterable (Traversable) agar bisa dipakai di @forelse.
 */
class ApiPaginator implements PaginatorContract, \IteratorAggregate
{
    protected Collection $items;
    protected int $currentPage;
    protected int $lastPage;
    protected int $perPage;
    protected int $total;
    protected array $appendQuery = [];

    public function __construct(Collection $items, int $currentPage, int $lastPage, int $perPage, int $total)
    {
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
        $this->perPage = $perPage;
        $this->total = $total;
    }

    /**
     * Buat ApiPaginator dari response API Shinigami.
     *
     * @param array $response  Full JSON response dari API
     * @param callable $mapper  Callback untuk map setiap item API → DTO
     */
    public static function fromResponse(array $response, callable $mapper): self
    {
        $pagination = $response['pagination'] ?? [];
        $data = $response['data'] ?? [];

        $items = collect($data)->map($mapper)->values();

        return new self(
            items: $items,
            currentPage: $pagination['current_page'] ?? 1,
            lastPage: $pagination['total_pages'] ?? 1,
            perPage: $pagination['page_size'] ?? count($data),
            total: $pagination['total_record'] ?? count($data),
        );
    }

    public function hasPages(): bool
    {
        return $this->lastPage > 1;
    }

    public function onFirstPage(): bool
    {
        return $this->currentPage <= 1;
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function lastPage(): int
    {
        return $this->lastPage;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function firstItem(): ?int
    {
        return $this->items->isEmpty() ? null : ($this->currentPage - 1) * $this->perPage + 1;
    }

    public function lastItem(): ?int
    {
        return $this->items->isEmpty() ? null : $this->firstItem() + $this->items->count() - 1;
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    public function isNotEmpty(): bool
    {
        return $this->items->isNotEmpty();
    }

    public function getCollection(): Collection
    {
        return $this->items;
    }

    public function items(): array
    {
        return $this->items->all();
    }

    public function path(): string
    {
        return request()->path();
    }

    public function fragment($fragment = null): self
    {
        return $this;
    }

    public function withQueryString(): self
    {
        $this->appendQuery = array_merge(
            $this->appendQuery,
            request()->except('page')
        );
        return $this;
    }

    /**
     * Append query parameters for pagination links.
     */
    public function appends($key, $value = null): self
    {
        if (is_array($key)) {
            $this->appendQuery = array_merge($this->appendQuery, $key);
        } else {
            $this->appendQuery[$key] = $value;
        }
        return $this;
    }

    /**
     * Build query string with appended params.
     */
    protected function buildQuery(int $page): string
    {
        $params = array_merge($this->appendQuery, ['page' => $page]);
        return http_build_query($params);
    }

    public function url($page): string
    {
        return '?' . $this->buildQuery($page);
    }

    public function previousPageUrl(): ?string
    {
        if ($this->onFirstPage()) {
            return null;
        }
        return $this->url($this->currentPage - 1);
    }

    public function nextPageUrl(): ?string
    {
        if (!$this->hasMorePages()) {
            return null;
        }
        return $this->url($this->currentPage + 1);
    }

    public function render($view = null, $data = []): string
    {
        return '';
    }

    /**
     * IteratorAggregate — agar bisa dipakai di @forelse.
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items->all());
    }

    public function __debugInfo(): array
    {
        return [
            'currentPage' => $this->currentPage,
            'lastPage' => $this->lastPage,
            'total' => $this->total,
            'items' => $this->items->toArray(),
        ];
    }
}
