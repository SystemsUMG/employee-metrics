<?php

namespace App\Http\Controllers\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public bool $result;
    public $records;
    public int $statusCode;
    public string $message;
    public string $database;

    public function __construct(Request $request)
    {
        $this->result     = false;
        $this->records    = [];
        $this->message    = 'Ha ocurrido un error.';
        $this->statusCode = 400;
        $this->database = $request->header('Database');
    }

    //Response para todos los servicios
    public function jsonResponse($result, $records, $message, $statusCode)
    {
        $response = [
            'result'  => $result,
            'records' => $records,
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }
}
