<?php

try {
    require "../initialize.php";

    $customerproductvisibility = $oro->customerproductvisibilities->get('1-1-1')->delete();
    echo "<p>Customerproductvisibility deleted</p>";
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
