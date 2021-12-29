<?php

try {
    require "../initialize.php";

    $users = $oro->users->get(['id' => 54]);

    $res = $users[0]->update([
      'data' => [
        'type' => 'users',
        'id' => '54',
        'attributes' => [
          'enabled' => ! $users[0]->attributes->enabled,
        ],
      ],
    ]);

    $user = $oro->users->get(['id' => 54]);
    echo "<p>Userrole updated: {$user[0]->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
