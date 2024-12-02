<?php

use App\Models\ShortenedUrl;
use App\Repositories\ShortenedUrlRepository;
use Tests\TestCase;

class GetOriginalUrlTest extends TestCase
{
    public function test_the_application_get_original_url_by_code()
    {

        $mockedShortenedUrl = ShortenedUrl::factory()->create(['original_url' => 'https://laravel.com/', 'code' => 'e16cf']);

        $repositoryMock = Mockery::mock(ShortenedUrlRepository::class);

        $repositoryMock->shouldReceive('findByCode')
            ->andReturn($mockedShortenedUrl);

        $this->app->instance(ShortenedUrlRepository::class, $repositoryMock);

        $response = $this->getJson('/api/shortened-urls/e16cf');

        $responseData = $response->json();
        $this->assertEquals($responseData['data'], "https://laravel.com/");
        $response->assertStatus(200);
    }

    public function test_the_application_respond_not_found_code_404()
    {
        $mockedRepositoryData = null;

        $repositoryMock = Mockery::mock(ShortenedUrlRepository::class);

        $repositoryMock->shouldReceive('findByCode')
            ->andReturn($mockedRepositoryData);

        $this->app->instance(ShortenedUrlRepository::class, $repositoryMock);

        $response = $this->getJson('/api/shortened-urls/e16cf');

        $responseData = $response->json();

        $response->assertStatus(404);
        $this->assertEquals($responseData['message'], 'No se ha encontrado el URL');
    }
}
