<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenedUrl extends Model
{

    use HasFactory;

    protected $table = 'shortened_urls';

    protected $fillable = ['code', 'original_url'];
}
