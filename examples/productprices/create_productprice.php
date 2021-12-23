<?php

try {
    require "../initialize.php";
    
    $productprice = $oro->productprices->create([
      'data' => [
        'type' => 'productprices',
        'attributes' => [
          'quantity' => 31,
          'currency' => 'EUR',
          'value' => 131.00,
        ],
        'relationships' => [
          'priceList' => [
            'data' => [
              'type' => 'pricelists',
              'id' => '1',
            ],
          ],
          'product' => [
            'data' => [
              'type' => 'products',
              'id' => '3',
            ],
          ],
          'unit' => [
            'data' => [
              'type' => 'productunits',
              'id' => 'set',
            ],
          ],
        ],
      ],
    ]);

    echo "<p>Productprice created: {$productprice->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
