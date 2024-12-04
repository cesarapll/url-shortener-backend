<?php

use App\Models\ShortenedUrl;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GetOriginalUrlTest extends TestCase
{

    use DatabaseTransactions;

    protected $shortenedUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortenedUrl = ShortenedUrl::factory()->create(['original_url' => 'https://laravel.com/', 'code' => 'a43sd5']);
    }

    public function test_the_application_get_original_url_by_code()
    {

        $response = $this->getJson('/api/shortened-urls/' . $this->shortenedUrl->code);

        $responseData = $response->json();
        $response->assertJsonStructure([
            'success',
            'data'
        ]);
        $this->assertEquals($responseData['data'],  $this->shortenedUrl->original_url);
        $response->assertStatus(200);
    }

    public function test_the_application_return_not_found_error()
    {

        $response = $this->getJson('/api/shortened-urls/a');

        $responseData = $response->json();

        $response->assertStatus(404);
        $this->assertEquals($responseData['message'], 'No se ha encontrado el URL');
    }
}
