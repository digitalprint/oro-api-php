<?php

try {
    require "../initialize.php";

    $product = $oro->products->get(1, ['include' => 'names,descriptions']);

    echo '<b>' . $product->type . ' ' . $product->id . '</b><br><br>';

    foreach ($product->included as $include) {
        echo $include->type . "<br>";
        echo $include->id . "<br>";

        foreach ($include->attributes as $key => $val) {
            echo $key . ": " . $val . "<br>";
        }

        echo "<br>";
    }
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
