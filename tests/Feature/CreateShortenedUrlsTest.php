<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;



class CreateShortenedUrlsTest extends TestCase
{

    use DatabaseTransactions;

    public function test_the_application_create_shortened_urls_if_another_url_exists_with_code()
    {

        $response = $this->json('POST', '/api/shortened-urls', [
            'original_url' =>  'https://laravel.com/'
        ]);

        $responseData = $response->json();

        $this->assertNotNull($responseData['data']['code']);
        $this->assertNotEmpty($responseData['data']['code']);
        $this->assertEquals(true, $responseData['success']);
        $this->assertEquals('https://laravel.com/', $responseData['data']['original_url']);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'code',
                'original_url',
                'created_at',
                'updated_at'
            ]
        ]);
        $response->assertStatus(201);
    }

    public function test_the_application_return_validation_error_on_empty_url()
    {
        $response = $this->json('POST', '/api/shortened-urls', [
            'original_url' =>  ''
        ]);

        $responseData = $response->json();

        $errors = $responseData['errors'];
        $message = $responseData['message'];

        $this->assertEquals(false, $responseData['success']);
        $this->assertNotEmpty($message);
        $this->assertEquals('El URL original no es válido', $message);
        $this->assertNotEmpty($errors);
        $this->assertNotEmpty($errors['original_url']);
        $this->assertEquals('El URL original es requerido', $errors['original_url'][0]);
        $response->assertStatus(422);
    }

    public function test_the_application_return_validation_error_on_incorrect_url_format()
    {
        $response = $this->post('/api/shortened-urls', [
            'original_url' =>  'asdg412/%'
        ]);

        $responseData = $response->json();

        $errors = $responseData['errors'];
        $message = $responseData['message'];

        $this->assertEquals(false, $responseData['success']);
        $this->assertNotEmpty($message);
        $this->assertEquals('El URL original no es válido', $message);
        $this->assertNotEmpty($errors);
        $this->assertNotEmpty($errors['original_url']);
        $this->assertEquals('El URL original no tiene el formato correcto', $errors['original_url'][0]);
        $response->assertStatus(422);
    }
}
