<?php

try {
    require "../initialize.php";

    $customerproductvisibility = $oro->customerproductvisibilities->create([
      'data' => [
        'type' => 'customerproductvisibilities',
        'attributes' => [
          'visibility' => 'visible',
        ],
        'relationships' => [
          'product' => [
            'data' => [
              'type' => 'products',
              'id' => '1',
            ],
          ],
          'customer' => [
            'data' => [
              'type' => 'customers',
              'id' => '1',
            ],
          ],
          'website' => [
            'data' => [
              'type' => 'websites',
              'id' => '1',
            ],
          ],
        ],
      ],
    ]);

    echo "<p>Customerproductvisibilty created: $customerproductvisibility->id</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
