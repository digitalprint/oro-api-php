<?php

try {
    require "../initialize.php";
    
    $address = $oro->addresses->create([
      'data' => [
        'type' => 'addresses',
        'attributes' => [
          'label' => 'Home',
          'street' => '1475 Harigun Drive',
          'city' => 'Dallas',
          'postalCode' => '04759',
          'organization' => 'Dallas Nugets',
          'namePrefix' => 'Mr.',
          'firstName' => 'Jerry',
          'middleName' => 'August',
          'lastName' => 'Coleman',
          'nameSuffix' => 'd\'',
        ],
        'relationships' => [
          'country' => [
            'data' => [
              'type' => 'countries',
              'id' => 'US',
            ],
          ],
          'region' => [
            'data' => [
              'type' => 'regions',
              'id' => 'US-NY',
            ],
          ],
        ],
      ],
    ]);

    echo "<p>Address created: {$address->id}</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
