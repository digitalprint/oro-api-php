<?php

try {
    require "../initialize.php";

    $addresstype = $oro->addresstypes->get('billing');

    echo "<b>{$addresstype->type} {$addresstype->id}</b><br>";
    foreach ($addresstype->attributes as $key => $val) {
        echo "{$key}: {$val}<br>";
    }

} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
