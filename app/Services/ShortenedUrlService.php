<?php


namespace App\Services;


use App\Repositories\Interfaces\ShortenedUrlRepositoryInterface;
use App\Traits\UrlHasher;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShortenedUrlService
{
    use UrlHasher;

    public function __construct(protected ShortenedUrlRepositoryInterface $shortenedUrlRepository) {}

    public function list()
    {

        return $this->shortenedUrlRepository->list();
    }

    public function shortUrl($payload)
    {

        $original_url = $payload['original_url'];
        $code = '';
        do {
            $code = $this->hashUrl($original_url);
            $existingUrl = $this->shortenedUrlRepository->findByCode($code);
        } while ($existingUrl);

        $createdShortenedUrl = $this->shortenedUrlRepository->create($code, $original_url);

        if (!$createdShortenedUrl) {
            throw new HttpException(500, 'Error al crear el url acortado');
        }

        return $createdShortenedUrl;
    }

    public function delete($id)
    {
        $currentShortenedUrl = $this->shortenedUrlRepository->findById($id);

        if (!$currentShortenedUrl) {
            throw new HttpException(404, 'URL acortado no existe');
        }

        $deletedShortenedUrl = $currentShortenedUrl->delete();

        if (!$deletedShortenedUrl) {
            throw new HttpException(500, 'Error al eliminar url acortado');
        }

        return $deletedShortenedUrl;
    }

    public function getOriginalUrl($code)
    {
        $shortenedUrlObject = $this->shortenedUrlRepository->findByCode($code);
        if (!$shortenedUrlObject) {
            throw new HttpException(404, 'No se ha encontrado el URL');
        }

        return $shortenedUrlObject->original_url;
    }
}
