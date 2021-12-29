<?php

try {
    require "../initialize.php";

    $address = $oro->addresses->get(4)->delete();
    echo "<p>Address deleted</p>";
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
