<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="ShortenedUrl",
 *     type="object",
 *     title="ShortenedUrl",
 *     description="Shortened URL model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="e1is8a", description="URL encrypted into a unique code"),
 *     @OA\Property(property="original_url", type="string", format="url", example="https://laravel.com/"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-12-03T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-12-03T12:34:56Z"),
 * )
 */
class ShortenedUrl extends Model
{

    use HasFactory;

    protected $table = 'shortened_urls';

    protected $fillable = ['code', 'original_url'];
}
