<?php

try {
    require "../initialize.php";

    $products = $oro->products->delete(['id' => 115]);
    echo "<p>Product deleted</p>";

} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
