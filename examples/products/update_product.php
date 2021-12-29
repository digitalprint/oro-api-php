<?php

try {
    require "../initialize.php";

    $product = $oro->products->get(104);

    $res = $product->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'products',
        'id' => $product->id,
        'attributes' => [
          'status' => ($product->attributes->status === 'disabled' ? "enabled" : "disabled"),
        ],
      ],
    ]);

    echo "<p>Product updated: {$res->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
