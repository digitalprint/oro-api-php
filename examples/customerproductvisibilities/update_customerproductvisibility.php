<?php

try {
    require "../initialize.php";

    $address = $oro->customerproductvisibilities->get('1-1-1');

    $res = $address->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'customerproductvisibilities',
        'id' => '1-1-1',
        'attributes' => [
          'visibility' => 'visible',
        ],
      ],
    ]);

    echo "<p>Customerproductvisibility updated: $res->id</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
