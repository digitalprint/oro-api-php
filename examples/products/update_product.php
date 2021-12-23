<?php

try {
    require "../initialize.php";

    $products = $oro->products->get(['id' => 104]);

    $res = $products[0]->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'products',
        'id' => $products[0]->id,
        'attributes' => [
          'status' => ($products[0]->attributes->status === 'disabled' ? "enabled" : "disabled"),
        ],
      ],
    ]);

    $products = $oro->products->get(['id' => 104]);
    echo "<p>Product updated: {$products[0]->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
