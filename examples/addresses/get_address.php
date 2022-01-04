<?php

try {
    require "../initialize.php";

    $address = $oro->addresses->get(3);

    echo "<b>{$address->type} {$address->id}</b><br>";
    foreach ($address->attributes as $key => $val) {
        echo "{$key}: {$val}<br>";
    }


} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
