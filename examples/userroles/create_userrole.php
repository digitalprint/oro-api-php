<?php

try {
    require "../initialize.php";

    $userrole = $oro->userroles->create([
      'data' => [
        'type' => 'userroles',
        'attributes' => [
          'extend_description' => 'A api guest role',
          'role' => 'IS_AUTHENTICATED_AT_FIRST',
          'label' => 'Api Guest',
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

    echo "<p>Userrole created: $userrole->id</p>";

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
