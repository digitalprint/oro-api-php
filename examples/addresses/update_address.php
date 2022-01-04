<?php

try {
    require "../initialize.php";

    $address = $oro->addresses->get(3);

    $res = $address->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'addresses',
        'id' => $address[0]->id,
        'attributes' => [
          'city' => 'Dallas',
        ],
      ],
    ]);

    echo "<p>Address updated: {$res->id}</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
