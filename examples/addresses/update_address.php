<?php

try {
    require "../initialize.php";

    $addresses = $oro->addresses->get(['id' => 3]);

    $res = $addresses[0]->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'addresses',
        'id' => $addresses[0]->id,
        'attributes' => [
          'city' => 'Dallas',
        ],
      ],
    ]);

    echo "<p>Address updated: {$res->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
