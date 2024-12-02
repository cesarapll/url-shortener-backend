<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenedUrlRequest;
use App\Services\ShortenedUrlService;
use App\Traits\ApiResponse;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShortenedUrlController extends Controller
{

    use ApiResponse;

    public function __construct(protected ShortenedUrlService $shortenedUrlService) {}

    public function list()
    {

        try {
            $shortenedUrlList = $this->shortenedUrlService->list();

            return response()->json([
                'success' => true,
                'data' => $shortenedUrlList
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function create(ShortenedUrlRequest $request)
    {
        try {

            $request->validated();

            $shortenedUrlCreated = $this->shortenedUrlService->shortUrl($request->all());

            $responseObject = [
                'success' => true,
                'data' => $shortenedUrlCreated
            ];

            return response()->json($responseObject, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getOriginalUrl($code)
    {
        try {

            $originalUrl = $this->shortenedUrlService->getOriginalUrl($code);

            $responseObject = [
                'success' => true,
                'data' => $originalUrl
            ];

            return response()->json($responseObject, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function delete($id)
    {
        try {

            $deletedUrl = $this->shortenedUrlService->delete($id);

            $responseObject = [
                'success' => true,
                'data' => $deletedUrl
            ];

            return response()->json($responseObject, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
