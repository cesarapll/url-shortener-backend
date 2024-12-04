<?php

namespace Tests\Feature;

use App\Models\ShortenedUrl;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteShortenedUrlTest extends TestCase
{
    use DatabaseTransactions;

    protected $shortenedUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shortenedUrl = ShortenedUrl::factory()->create(['original_url' => 'https://laravel.com/', 'code' => 'a43sd5']);
    }

    public function test_the_application_delete_a_shortened_url(): void
    {
        $response = $this->delete('/api/shortened-urls/' . $this->shortenedUrl->id);
        $responseData = $response->json();

        $this->assertEquals(true, $responseData['success']);
        $this->assertEquals('URL acortado eliminado con éxito', $responseData['message']);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
        $response->assertStatus(200);
    }

    public function test_the_application_return_validation_error_on_incorrect_id_format(): void
    {

        $response = $this->delete('/api/shortened-urls/a');
        $responseData = $response->json();

        $this->assertEquals(false, $responseData['success']);
        $this->assertEquals('El ID no es válido', $responseData['message']);
        $response->assertJsonStructure([
            'success',
            'message',
            'errors'
        ]);
        $this->assertNotEmpty($responseData['errors']);
        $response->assertStatus(422);
    }
}
