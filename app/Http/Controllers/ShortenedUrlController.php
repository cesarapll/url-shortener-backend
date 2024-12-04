<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenedUrlRequest;
use App\Services\ShortenedUrlService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShortenedUrlController extends Controller
{

    use ApiResponse;

    public function __construct(protected ShortenedUrlService $shortenedUrlService) {}


    /**
     * @OA\Get(
     *     path="/api/shortened-urls",
     *     summary="List all shortened URL's",
     *     tags={"Shortened URL's"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Shortened URL's retrieved succesfully",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(ref="#/components/schemas/ShortenedUrl"))
     *         )
     *     )
     * 
     *
     * )
     * 
     *
     * @return JsonResponse
     * @throws Exception
     */


    public function list(): JsonResponse
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


    /**
     * @OA\Post(
     *     path="/api/shortened-urls",
     *     summary="Create a shortened URL",
     *     tags={"Shortened URL's"},
     *  
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\schema(ref="#/components/schemas/ShortenedUrlRequest")
     *       )
     *      ),
     * 
     *     @OA\Response(
     *         response=201,
     *         description="Shortened URL created succesfully",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/ShortenedUrl")
     *         )
     *     ),
     *    @OA\Response(
     *          response=422,
     *          description="Original URL validation error",
     *           @OA\JsonContent(
     *            @OA\Property(property="success", type="boolean", example=false),
     *            @OA\Property(property="message", type="string", example="El URL original no es válido"),
     *             @OA\Property(
     *               property="errors",
     *               type="object",
     *               @OA\Property(
     *                   property="original_url",
     *                   type="array",
     *                   @OA\Items(type="string", example="El URL original no tiene el formato correcto")
     *               )
     *           )
     *          )
     *      ),
     * 
     *       @OA\Response(
     *          response=500,
     *          description="Shortened URL creation failed",
     *           @OA\JsonContent(
     *             type="object",
     *            @OA\Property(property="success", type="boolean", example=false),
     *            @OA\Property(property="message", type="string", example="Error crear el URL acortado")
     *          )
     *      ),
     *  
     *
     *   )
     *      
     *   @param  ShortenedUrlRequest $request
     *   @return JsonResponse
     *   @throws Exception
     */

    public function create(ShortenedUrlRequest $request): JsonResponse
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

    /**
     * @OA\Get(
     *     path="/api/shortened-urls/{code}",
     *     summary="Get original URL by code",
     *     tags={"Shortened URL's"},
     * 
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         description="Unique code assigned to URL",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="e817a"
     *         )
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Original URL retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="data", type="string", format="url", example="https://laravel.com/")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=404,
     *         description="Original URL not found",
     *           @OA\JsonContent(
     *             type="object",
     *            @OA\Property(property="success", type="boolean", example=false),
     *            @OA\Property(property="message", type="string", example="No se ha encontrado el URL")
     *          )
     *     )
     *
     * )
     * 
     *   @param  string $code
     *   @return JsonResponse
     *   @throws Exception
     */
    public function getOriginalUrl(string $code): JsonResponse
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

    /**
     * @OA\Delete(
     *     path="/api/shortened-urls/{id}",
     *     summary="Delete shortened URL by id",
     *     tags={"Shortened URL's"},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the shortened URL",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example="1"
     *         )
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Shortened URL deleted succesfully",
     *         @OA\JsonContent(
     *             type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="URL acortado eliminado con éxito")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=404,
     *         description="Shortened URL not found",
     *           @OA\JsonContent(
     *             type="object",
     *            @OA\Property(property="success", type="boolean", example=false),
     *            @OA\Property(property="message", type="string", example="URL acortado no existe")
     *          )
     *     ),
     * 
     *      @OA\Response(
     *          response=422,
     *          description="ID validation error",
     *           @OA\JsonContent(
     *            @OA\Property(property="success", type="boolean", example=false),
     *            @OA\Property(property="message", type="string", example="El ID no es válido"),
     *             @OA\Property(
     *               property="errors",
     *               type="object",
     *               @OA\Property(
     *                   property="id",
     *                   type="array",
     *                   @OA\Items(type="string", example="El ID debe ser numérico")
     *               )
     *           )
     *          )
     *      ),
     * 
     *   @OA\Response(
     *         response=500,
     *         description="Shortened URL deletion failed",
     *           @OA\JsonContent(
     *             type="object",
     *            @OA\Property(property="success", type="boolean", example=false),
     *            @OA\Property(property="message", type="string", example="Error al eliminar URL acortado")
     *          )
     *     ),
     *
     * )
     * 
     *   @param  string $id
     *   @return JsonResponse
     *   @throws Exception
     * 
     */

    public function delete(string $id): JsonResponse
    {
        try {

            $validator = Validator::make(
                ['id' => $id],
                [
                    'id' => 'integer|min:1'
                ],
                [
                    'id.integer' => 'El ID debe ser numérico',
                    'id.min' => 'El valor mínimo del ID es 1'
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'El ID no es válido',
                        'errors' => $validator->errors()
                    ],
                    422
                );
            }

            $deletedUrl = $this->shortenedUrlService->delete($id);

            $responseObject = [
                'success' => $deletedUrl,
                'message' => "URL acortado eliminado con éxito"
            ];

            return response()->json($responseObject, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
