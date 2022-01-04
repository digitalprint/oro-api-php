<?php

try {
    require "../initialize.php";

    echo '<ul>';

    $products = $oro->products->page();

    foreach ($products as $product) {
        echo '<li>';
        echo '<b>' . $product->type . ' ' . $product->id . '</b><br>';
        foreach ($product->attributes as $key => $val) {
            if (is_array($val)) {
                echo $key . ': ' . implode(', ', $val) . '<br>';
            } else {
                echo "{$key}: {$val}<br>";
            }
        }
        echo "</li>";
    }

    $nextProducts = $products->next();

    foreach ($nextProducts as $product) {
        echo '<li>';
        echo '<b>' . $product->type . ' ' . $product->id . '</b><br>';
        foreach ($product->attributes as $key => $val) {
            if (is_array($val)) {
                echo $key . ': ' . implode(', ', $val) . '<br>';
            } else {
                echo "{$key}: {$val}<br>";
            }
        }
      echo "</li>";
    }

    echo '</ul>';

} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
