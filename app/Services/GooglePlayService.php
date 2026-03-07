<?php

namespace App\Services;

use Google\Client;
use Google\Service\AndroidPublisher;

class GooglePlayService
{
    protected AndroidPublisher $service;

    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(config('services.google.play_service_account'));
        $client->addScope(AndroidPublisher::ANDROIDPUBLISHER);

        $this->service = new AndroidPublisher($client);
    }

    public function verifyProduct(string $packageName, string $productId, string $purchaseToken)
    {
        return $this->service->purchases_products->get(
            $packageName,
            $productId,
            $purchaseToken
        );
    }

    public function acknowledgeProduct(string $packageName, string $productId, string $purchaseToken)
    {
        $this->service->purchases_products->acknowledge(
            $packageName,
            $productId,
            $purchaseToken,
            new AndroidPublisher\ProductPurchasesAcknowledgeRequest()
        );
    }

    public function consumeProduct(string $packageName, string $productId, string $purchaseToken)
    {
        $this->service->purchases_products->consume(
            $packageName,
            $productId,
            $purchaseToken
        );
    }
}
