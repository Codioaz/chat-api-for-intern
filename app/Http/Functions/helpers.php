<?php

use Symfony\Component\HttpFoundation\Response;

if (! function_exists('collection_to_array')){
    function collection_to_array($collection): array
    {
        return json_decode(json_encode($collection), true);
    }
}

if (! function_exists('codioResponse')){
    /**
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return \Response
     */
    function codioResponse(array $data = [], int $code = Response::HTTP_OK, array $headers = []): Illuminate\Http\Response
    {
        return response($data, $code, $headers);
    }
}


