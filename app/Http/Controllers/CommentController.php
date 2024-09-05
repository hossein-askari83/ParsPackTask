<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Entities\User;
use App\Events\CommentStoredEvent;
use App\Facades\CommentFacade;
use App\Facades\ProductFacade;
use App\Facades\UserFacade;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @api {POST} /comment/
     * @apiDescription Create a new comment | if product dosent exist,will create it.
     * @apiBody {comment}
     * @apiBody {product}
     * 
     * @param StoreCommentRequest $request
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $userId = UserFacade::parseTokenToUserId();
        $user = UserFacade::findUser($userId);

        $commentText = $request->get('comment');
        $productName = $request->get('product');

        $product = ProductFacade::findProductByName($productName);
        if (!$product)
            $product = ProductFacade::createProduct($productName);

        if (!$this->checkUserCommentConstraint($user, $product))
            abort(Response::HTTP_FORBIDDEN);

        $userId = UserFacade::parseTokenToUserId();
        $user = UserFacade::findUser($userId);
        $comment = CommentFacade::createComment($commentText, $user, $product);

        event(new CommentStoredEvent($comment));

        return response()->json($this->normalizeResponse($comment));
    }

    /**
     * Check user comment constraint and returns true if user was enable to comment
     *
     * @param User $user
     * @return bool
     */
    protected function checkUserCommentConstraint(User $user, Product $product): bool
    {
        $userCommentsForProduct = $user->getComments()->filter(function ($comment) use ($product) {
            return $comment->getProduct()->getId() === $product->getId();
        });

        if (count($userCommentsForProduct) >= User::USER_COMMENT_CONSTRAINTS) {
            return false;
        }

        return true;
    }
}
