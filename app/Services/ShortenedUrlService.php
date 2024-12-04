<?php


namespace App\Services;

use App\Models\ShortenedUrl;
use App\Repositories\Interfaces\ShortenedUrlRepositoryInterface;
use App\Traits\UrlHasher;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShortenedUrlService
{
    use UrlHasher;

    public function __construct(protected ShortenedUrlRepositoryInterface $shortenedUrlRepository) {}

    /** 
     * 
     * @return Collection
     * 
     */
    public function list(): Collection
    {

        return $this->shortenedUrlRepository->list();
    }

    /** 
     * 
     * @param array $payload
     * @return ShortenedUrl
     * 
     */
    public function shortUrl(array $payload): ShortenedUrl
    {

        $original_url = $payload['original_url'];
        $code = '';
        do {
            $code = $this->hashUrl($original_url);
            $existingUrl = $this->shortenedUrlRepository->findByCode($code);
        } while ($existingUrl);

        $createdShortenedUrl = $this->shortenedUrlRepository->create($code, $original_url);

        if (!$createdShortenedUrl) {
            throw new HttpException(500, 'Error al crear el URL acortado');
        }

        return $createdShortenedUrl;
    }

    /** 
     * 
     * @param int $id
     * @return bool
     * 
     */
    public function delete(int $id): bool
    {
        $currentShortenedUrl = $this->shortenedUrlRepository->findById($id);

        if (!$currentShortenedUrl) {
            throw new HttpException(404, 'URL acortado no existe');
        }

        $deletedShortenedUrl = $currentShortenedUrl->delete();

        if (!$deletedShortenedUrl) {
            throw new HttpException(500, 'Error al eliminar URL acortado');
        }

        return $deletedShortenedUrl;
    }

    /** 
     * 
     * @param string $code
     * @return string
     * 
     */
    public function getOriginalUrl(string $code): string
    {
        $shortenedUrlObject = $this->shortenedUrlRepository->findByCode($code);
        if (!$shortenedUrlObject) {
            throw new HttpException(404, 'No se ha encontrado el URL');
        }

        return $shortenedUrlObject->original_url;
    }
}
