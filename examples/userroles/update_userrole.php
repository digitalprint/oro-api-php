<?php

try {
    require "../initialize.php";

    $userrole = $oro->userroles->get(10);

    $res = $userrole->update([
      'data' => [
        'type' => 'userroles',
        'id' => $userrole->id,
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

    echo "<p>Userrole updated: {$res->id}</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
