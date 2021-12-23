<?php

try {
    require "../initialize.php";

    $productprices = $oro->productprices->get(['priceList' => 1]);

    echo '<ul>';
    foreach ($productprices as $productprice) {
        echo '<li>';
        echo "<b>{$productprice->type} {$productprice->id}</b><br>";
        foreach ($productprice->attributes as $key => $val) {
            echo "{$key}: {$val}<br>";
        }
        echo "</li>";
    }
    echo '</ul>';
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
