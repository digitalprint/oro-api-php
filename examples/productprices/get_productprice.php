<?php

try {
    require "../initialize.php";

    $productprice = $oro->productprices->get('05d75108-4f05-489c-95d5-f80d120673f4-1');

    echo "<b>{$productprice->type} {$productprice->id}</b><br>";
    foreach ($productprice->attributes as $key => $val) {
        echo "{$key}: {$val}<br>";
    }

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
