<?php

try {
    require "../initialize.php";

    $userrole = $oro->userroles->delete(['id' => 115]);
    echo "<p>Userrole deleted</p>";

} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
