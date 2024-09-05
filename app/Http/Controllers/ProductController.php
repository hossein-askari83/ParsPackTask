<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Entities\User;
use App\Facades\ProductFacade;
use App\Facades\UserFacade;
use Doctrine\ORM\EntityManagerInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 *
 * Handles products requests
 */
class ProductController extends Controller
{

    /**
     * @api {GET} /products/
     * @apiDescription Returns a list of products with relative comments
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = ProductFacade::findAllProducts();
        $serializerGroups = ['basic', 'with-comments'];

        return response()->json($this->normalizeResponse($products, $serializerGroups));
    }
}
