<?php

try {
    require "../initialize.php";

    $products = $oro->productprices->delete(['priceList' => 1, 'id' => '5eaa0c39-6d5e-41dc-b4df-fc2dde028bb8-1']);
    echo "<p>Productprice deleted</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
