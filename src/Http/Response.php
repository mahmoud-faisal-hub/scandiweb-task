<?php

namespace Mahmoud\ScandiwebTask\Http;

class Response
{
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
