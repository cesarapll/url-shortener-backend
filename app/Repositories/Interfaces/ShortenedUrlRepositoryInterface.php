<?php

namespace App\Repositories\Interfaces;


interface ShortenedUrlRepositoryInterface
{
    public function list();
    public function create($code, $original_url);
    public function findById($id);
    public function findByCode($code);
}
