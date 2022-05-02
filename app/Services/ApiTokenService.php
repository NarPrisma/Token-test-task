<?php

namespace App\Services;

use App\Constants\AppConstants;
use Illuminate\Support\Facades\Http;

class ApiTokenService
{
    private $url;
    private $headers;

    /**
     * Set url
     *
     * @param string $url
     * @return void
     */
    public function setUrl(string $url)
    {
        $this->url = AppConstants::APIBASEURL.$url;
    }


    /**
     * Set api headers
     *
     * @return void
     */
    public function setHeaders()
    {
        $this->headers = [AppConstants::HEADERS => config('api.api_key')];
    }

    /**
     * Getting all data about tokens
     *
     * @return array
     */
    public function getApiData():array
    {
        $this->setHeaders();
        $this->setUrl('cryptocurrency/listings/latest');
        $response = $this->request('get');
        $message = 'error';
        if($response){
            $data = json_decode($response->body(), true)['data'];
            $message = 'success';
        }
        return ['data' => $data ?? [], 'message' => $message];
    }

    /**
     * Make api request
     *
     * @param string $type
     * @return object|false
     */

    public function request(string  $type)
    {
       $response = Http::withHeaders($this->headers)->$type($this->url);
       if($response->status() == 200){
           return $response;
       }
       return false;
    }

    /**
     * Get all tokens, reform and send.
     *
     * @return array
     */
    public function reformTokenData():array
    {
        $tokenData = $this->getApiData();
        $userTokens = auth()->user()->tokens;
        $result = [];
        foreach ($userTokens as $token) {
            $api = $tokenData['data'][$token->index];
            $tokenCount = $token->count;
            $tokenPrice = $token['price'];
            $realPrice = $api['quote']['USD']['price'];
            $invest = $tokenCount * $tokenPrice;
            $currentAmount = $tokenCount * $realPrice;

            $result[] = [
                'Token' => $token['token_name'],
                'Symbol' => $token['symbol'],
                'Invest Amount' => $invest,
                'Current Amount' => round($tokenCount * $realPrice),
                'ROI' => round(( $currentAmount - $invest ) / $invest * 100) . '%'
            ];
        }
        return $result;
    }
}
