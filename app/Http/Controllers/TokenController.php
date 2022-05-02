<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTokenRequest;
use App\Models\Token;
use App\Services\ApiTokenService;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    protected $apiService;

    public function __construct(ApiTokenService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @param StoreTokenRequest $request
     * @return JsonResponse
     */
    public function storeToken(StoreTokenRequest $request):JsonResponse
    {
        Token::store($request);
        return response()->json();
    }

    /**
     * @return JsonResponse
     */
    public function getApiToken():JsonResponse
    {
        return response()->json($this->apiService->getApiData());
    }


    /**
     * Getting all tokens via api
     *
     * @return JsonResponse
     */
    public function getAllTokens():JsonResponse
    {
        return response()->json($this->apiService->reformTokenData());
    }
}
