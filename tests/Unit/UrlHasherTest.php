<?php

namespace Tests\Unit;

use App\Traits\UrlHasher;
use PHPUnit\Framework\TestCase;

class UrlHasherTest extends TestCase
{

    use UrlHasher;

    public function test_hash_url_with_valid_url()
    {

        $url = 'https://example.com';

        $hashedValue = $this->hashUrl($url);

        $this->assertIsString($hashedValue);
        $this->assertGreaterThanOrEqual(4, strlen($hashedValue));
        $this->assertLessThanOrEqual(6, strlen($hashedValue));
    }

}
