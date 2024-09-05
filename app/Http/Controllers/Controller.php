<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * Normalizez the given data and handle relations 
     * 
     * @param mixed $response
     * @param array $groups
     * @param bool $emptyAsObject
     * 
     * @return array
     */
    protected function normalizeResponse($response, $groups = ['basic'], $emptyAsObject = false): array
    {
        $serializer = app(Serializer::class);

        if ($emptyAsObject && empty($response)) {
            $response = (object) $response;
        }

        return $serializer->normalize($response, null, [
            AbstractNormalizer::GROUPS => $groups,
        ]);
    }
}
