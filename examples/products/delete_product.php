<?php

try {
    require "../initialize.php";

    $products = $oro->products->get(115)->delete();
    echo "<p>Product deleted</p>";

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
