<?php

try {
    require "../initialize.php";

    $userroles = $oro->userroles->get(['id' => 10]);

    $res = $userroles[0]->update([
      'data' => [
        'type' => 'userroles',
        'id' => $userroles[0]->id,
        'attributes' => [
          'extend_description' => 'A guest role new',
          'role' => 'IS_AUTHENTICATED_AT_FIRST',
          'label' => 'Guest',
        ],
        'relationships' => [
          'organization' => [
            'data' => [
              'type' => 'organizations',
              'id' => '1',
            ],
          ],
        ],
      ],
    ]);

    $userroles = $oro->userroles->get(['id' => 10]);
    echo "<p>Userrole updated: {$userroles[0]->id}</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
