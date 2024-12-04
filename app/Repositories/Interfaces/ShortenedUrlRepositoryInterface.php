<?php

namespace App\Repositories\Interfaces;

use App\Models\ShortenedUrl;
use Illuminate\Database\Eloquent\Collection;

interface ShortenedUrlRepositoryInterface
{
    public function list(): Collection;
    public function create(string $code, string $original_url): ShortenedUrl;
    public function findById(int $id): ?ShortenedUrl;
    public function findByCode(string $code): ?ShortenedUrl;
}
