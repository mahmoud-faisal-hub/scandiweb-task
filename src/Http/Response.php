<?php

namespace Mahmoud\ScandiwebTask\Http;

class Response
{
    public function __construct()
    {
        $allowedOrigins = explode(',', env('FRONTEND_URL'));

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            if (in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400'); // cache for 1 day
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, OPTIONS, DELETE");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
    }

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function back()
    {
        header("Location:" . $_SERVER["HTTP_REFERER"]);
    }

    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
