<?php

try {
    require "../initialize.php";

    $user = $oro->$users->get(11)->delete();
    echo "<p>User deleted</p>";

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
