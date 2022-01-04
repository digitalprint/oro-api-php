<?php

try {
    require "../initialize.php";

    $product = $oro->products->get(116);

    echo '<b>' . $product->type . ' ' . $product->id . '</b><br>';

    $names = $product->names();

    foreach ($names as $name) {
        foreach ($name->attributes as $key => $val) {
            echo "{$key}: {$val}<br>";
        }
    }
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
