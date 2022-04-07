<?php

try {
    require "../initialize.php";

    $customerproductvisibilities = $oro->customerproductvisibilities->page(1, 10);

    foreach ($customerproductvisibilities as $customerproductvisibility) {
        echo "<b>$customerproductvisibility->type $customerproductvisibility->id</b><br>";
        foreach ($customerproductvisibility->attributes as $key => $val) {
            echo "$key: $val<br>";
        }
    }
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
