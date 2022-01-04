<?php

try {
    require "../initialize.php";

    $product = $oro->products->create([
      'data' => [
        'type' => 'products',
        'attributes' => [
          'sku' => 'test-api-' . strtotime('now'),
          'status' => 'enabled',
          'variantFields' => [],
          'productType' => 'simple',
          'featured' => true,
          'newArrival' => false,
          'availability_date' => '2018-01-01',
        ],
        'relationships' => [
          'names' => [
            'data' => [
              [
                'type' => 'productnames',
                'id' => 'names-1',
              ],
            ],
          ],
          'attributeFamily' => [
            'data' => [
              'type' => 'attributefamilies',
              'id' => '1',
            ],
          ],
          'primaryUnitPrecision' => [
            'data' => [
              'type' => 'productunitprecisions',
              'id' => 'product-unit-precision-id-1',
            ],
          ],
          'unitPrecisions' => [
            'data' => [
              [
                'type' => 'productunitprecisions',
                'id' => 'product-unit-precision-id-1',
              ],
            ],
          ],
          'inventory_status' => [
            'data' => [
              'type' => 'prodinventorystatuses',
              'id' => 'out_of_stock',
            ],
          ],

        ],
      ],
      'included' => [
        [
          'type' => 'productnames',
          'id' => 'names-1',
          'attributes' => [
            'fallback' => null,
            'string' => 'Test product',
          ],
          'relationships' => [
            'localization' => [
              'data' => null,
            ],
          ],
        ],
        [
          'type' => 'productunitprecisions',
          'id' => 'product-unit-precision-id-1',
          'attributes' => [
            'precision' => '0',
            'conversionRate' => '5',
            'sell' => '1',
          ],
          'relationships' => [
            'unit' => [
              'data' => [
                'type' => 'productunits',
                'id' => 'piece',
              ],
            ],
          ],
        ],
      ],
    ]);

  echo "<p>Product created: {$product->id}</p>";

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
