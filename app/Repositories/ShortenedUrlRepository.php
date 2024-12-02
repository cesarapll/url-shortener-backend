<?php

namespace App\Repositories;

use App\Models\ShortenedUrl;
use App\Repositories\Interfaces\ShortenedUrlRepositoryInterface;

class ShortenedUrlRepository implements ShortenedUrlRepositoryInterface
{

    public function __construct(protected ShortenedUrl $shortenedUrl) {}

    public function list()
    {
        return $this->shortenedUrl->all();
    }

    public function create($code, $original_url)
    {
        return $this->shortenedUrl->create([
            'code' => $code,
            'original_url' => $original_url
        ]);
    }

    public function findById($id)
    {
        return $this->shortenedUrl->find($id);
    }

    public function findByCode($code)
    {
        return $this->shortenedUrl->where('code', $code)->first();
    }
}
