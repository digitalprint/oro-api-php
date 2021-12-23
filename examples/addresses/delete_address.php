<?php

try {
    require "../initialize.php";

    $address = $oro->addresses->delete(['id' => 2]);
    echo "<p>Address deleted</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
