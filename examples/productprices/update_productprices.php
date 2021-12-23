<?php

try {
    require "../initialize.php";

    $productprices = $oro->productprices->get(['priceList' => 1, 'id' => '5eaa0c39-6d5e-41dc-b4df-fc2dde028bb8-1']);

    $res = $productprices[0]->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'products',
        'id' => $productprices[0]->id,
        'attributes' => [
          'quantity' => 30,
          'currency' => 'EUR',
          'value' => 130,
        ],
      ],
    ]);

    echo "<p>Product updated: {$res[0]->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
