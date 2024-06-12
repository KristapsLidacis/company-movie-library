<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Base API controller class
 */
class ApiController extends Controller
{
    /**
     * Return a successful response with a 200 status code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ok($message, $data = [])
    {
        return $this->success($message, $data, 200);
    }

    /**
     * Return a successful response with a custom status code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message, $data = [], $statusCode = 200)
    {
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
        return response()->json([
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);  
    }
}
