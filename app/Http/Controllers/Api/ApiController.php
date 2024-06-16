<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Base API controller class
 */
class ApiController extends Controller
{
    // This class serves as a base for all API controllers and provides common functionality

    use AuthorizesRequests;

    /**
     * The policy class to use for authorization
     *
     * @var string
     */
    protected $policyClass;
    
    /**
     * Return a successful response with a 200 status code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ok($message, $data = [])
    {
        // Call the success method with a status code of 200
        return $this->success($message, $data, 200);
    }

    /**
     * Return a successful response with a custom status code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message, $data = [], $statusCode = 200)
    {
        // Create a JSON response with the message, data, and status code
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $statusCode
        ], $statusCode);        
    }

    /**
     * Return an error response with a custom status code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $statusCode = 400)
    {
        // Create a JSON response with the error message and status code
        return response()->json([
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);  
    }

    /**
     * Check if the user has a specific ability for a target model
     * 
     * @return bool Whether the user has the ability
     */
    public function isAble($abillity, $targetModel)
    {
        // Use the authorize method to check if the user has the ability
        return $this->authorize($abillity, [$targetModel, $this->policyClass]);
    }
}
