<?php

namespace App\Repositories;

use App\Models\ShortenedUrl;
use App\Repositories\Interfaces\ShortenedUrlRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ShortenedUrlRepository implements ShortenedUrlRepositoryInterface
{

    public function __construct(protected ShortenedUrl $shortenedUrl) {}

    public function list(): Collection
    {
        return $this->shortenedUrl->all();
    }

    public function create(string $code, string $original_url): ShortenedUrl
    {
        return $this->shortenedUrl->create([
            'code' => $code,
            'original_url' => $original_url
        ]);
    }

    public function findById(int $id): ?ShortenedUrl
    {
        return $this->shortenedUrl->find($id);
    }

    public function findByCode(string $code): ?ShortenedUrl
    {
        return $this->shortenedUrl->where('code', $code)->first();
    }
}
