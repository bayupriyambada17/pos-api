<?php

class ResponseFormatter
{
    public static function success($status, $message = null, $data)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function error($statusCode, $status, $message = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $statusCode);
    }

    public static function errorValidation($errors)
    {
        return response()->json([
            'errors' => $errors
        ], 422);
    }

    public static function errorUnauthorized()
    {
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    public static function errorForbidden()
    {
        return response()->json([
            'message' => 'Forbidden.'
        ], 403);
    }
}
