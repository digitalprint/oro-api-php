<?php

try {
    require "../initialize.php";

    $productprice = $oro->productprices->get('5eaa0c39-6d5e-41dc-b4df-fc2dde028bb8-1');

    $res = $productprice->update([
      'data' => [
        'type' => 'productprices',
        'id' => $productprice->id,
        'attributes' => [
          'quantity' => 30,
          'currency' => 'EUR',
          'value' => 130,
        ],
      ],
    ]);
    
    echo "<p>Productprice updated: {$res->id}</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
