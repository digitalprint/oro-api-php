<?php

try {
    require "../initialize.php";

    $user = $oro->users->get(11);

    $res = $user->update([
      'data' => [
        'type' => 'users',
        'id' => '54',
        'attributes' => [
          'enabled' => ! $user->attributes->enabled,
        ],
      ],
    ]);

    echo "<p>Userrole updated: {$res->id}</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
