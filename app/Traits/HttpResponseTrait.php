<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait HttpResponseTrait
{
    public function success($data, $status = "success", $message = null, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function dataNotFound($status = "success",$message = 'Data not found', $code = 200) {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }

    protected function delete($status = "success", $message = 'Success delete', $code = 200) {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }


    public function error($message, $code = 400, \Throwable $th = null)
    {
        if ($th) {
            Log::error($message, [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString()
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}