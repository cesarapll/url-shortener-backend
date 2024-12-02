<?php

namespace Tests\Feature;

use App\Models\ShortenedUrl;
use App\Repositories\ShortenedUrlRepository;
use Mockery;
use Tests\TestCase;

class CreateShortenedUrlsTest extends TestCase
{

    public function test_the_application_create_shortened_urls_if_another_url_exists_with_code()
    {

        $mockedShortenedUrl = ShortenedUrl::factory()->create(['original_url' => 'https://laravel.com/', 'code' => 'e16cf']);

        $repositoryMock = Mockery::mock(ShortenedUrlRepository::class);

        // Force first call returns a value
        $repositoryMock->shouldReceive('findByCode')
            ->andReturn($mockedShortenedUrl, []);

        $repositoryMock->shouldReceive('create')
            ->andReturnUsing(function ($code, $original_url) {
                return ShortenedUrl::factory()->create(['original_url' => $original_url, 'code' => $code]);;
            });


        $this->app->instance(ShortenedUrlRepository::class, $repositoryMock);

        $response = $this->json('POST', '/api/shortened-urls', [
            'original_url' =>  'https://laravel.com/'
        ]);

        $responseData = $response->json();

        $this->assertNotNull($responseData['data']['code']);
        $this->assertNotEmpty($responseData['data']['code']);
        $this->assertEquals('https://laravel.com/', $responseData['data']['original_url']);
        $response->assertStatus(201);
    }

    public function test_the_application_respond_with_error_on_empty_url()
    {
        $response = $this->json('POST', '/api/shortened-urls', [
            'original_url' =>  ''
        ]);

        $responseData = $response->json();

        $errors = $responseData['errors'];
        $message = $responseData['message'];

        $this->assertNotEmpty($message);
        $this->assertEquals('El URL original no es válido', $message);
        $this->assertNotEmpty($errors);
        $this->assertNotEmpty($errors['original_url']);
        $this->assertEquals('El URL original es requerido', $errors['original_url'][0]);
        $response->assertStatus(422);
    }

    public function test_the_application_respond_with_error_on_incorrect_url_format()
    {
        $response = $this->json('POST', '/api/shortened-urls', [
            'original_url' =>  'asdg412/%'
        ]);

        $responseData = $response->json();

        $errors = $responseData['errors'];
        $message = $responseData['message'];

        $this->assertNotEmpty($message);
        $this->assertEquals('El URL original no es válido', $message);
        $this->assertNotEmpty($errors);
        $this->assertNotEmpty($errors['original_url']);
        $this->assertEquals('El URL original no tiene el formato correcto', $errors['original_url'][0]);
        $response->assertStatus(422);
    }
}
