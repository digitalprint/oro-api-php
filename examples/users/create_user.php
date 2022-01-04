<?php

try {
    require "../initialize.php";

    $user = $oro->users->create([
      'data' => [
        'type' => 'users',
        'attributes' => [
          'username' => 'testapiuser',
          'email' => 'testuser@oroinc.com',
          'firstName' => 'Bob',
          'lastName' => 'Fedeson',
          'password' => 'Password000!',
        ],
        'relationships' => [
          'owner' => [
            'data' => [
              'type' => 'businessunits',
              'id' => '1',
            ],
          ],
          'organization' => [
            'data' => [
              'type' => 'organizations',
              'id' => '1',
            ],
          ],
        ],
      ],
    ]);

    echo "<p>User created: {$user->id}</p>";

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
