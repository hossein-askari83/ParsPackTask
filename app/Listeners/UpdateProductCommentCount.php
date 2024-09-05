<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateProductCommentCount implements ShouldQueue
{
    private readonly string $productCommentCountFilePath;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->productCommentCountFilePath = env('PRODUCT_COMMENT_COUNT_FILE_PATH', "/opt/myprogram/product_comments");
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (!file_exists($this->productCommentCountFilePath)) {
            exec("touch {$this->productCommentCountFilePath}");
            exec("chmod 664 {$this->productCommentCountFilePath}");
        }
        $product = $event->comment->getProduct();
        $commentCount = count($product->getComments()) + 1;
        $productName = $product->getName();
        $productLine = "{$productName}: {$commentCount}";

        $safeProductName = escapeshellarg($productName);
        $safeProductLine = escapeshellarg($productLine);
        $safeFilePath = escapeshellarg($this->productCommentCountFilePath);

        $command = "grep -q '^{$safeProductName}:' {$safeFilePath} && " .
            "sed -i 's/^{$safeProductName}:.*/{$safeProductLine}/' {$safeFilePath} || " .
            "echo '{$safeProductLine}' >> {$safeFilePath}";

        exec($command, $output, $returnVar);

        if ($returnVar !== 0)
            Log::error("Failed to update product comment count for {$safeProductName}. Command: {$command}");
    }
}
