<?php

namespace App\Traits;

trait UrlHasher
{

    public function generateSalt()
    {
        return bin2hex(random_bytes(16));
    }

    public function hashUrl($url)
    {
        $salt = $this->generateSalt();

        $saltedUrl = $salt . $url;

        $hashedValue = hash('sha256', $saltedUrl);

        return substr($hashedValue, 0, rand(4, 6));
    }
}
