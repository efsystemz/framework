<?php

namespace Efsystems\Framework;

class Response
{

    public function statusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public static function json(array $data = [])
    {
    	return;
    }

}