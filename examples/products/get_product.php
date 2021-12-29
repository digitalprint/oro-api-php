<?php

try {
    require "../initialize.php";

    $product = $oro->products->get(116);

    echo '<b>' . $product->type . ' ' . $product->id . '</b><br>';
    foreach ($product->attributes as $key => $val) {
        if (is_array($val)) {
            echo $key . ': ' . implode(', ', $val) . '<br>';
        } else {
            echo "{$key}: {$val}<br>";
        }
    }

} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
