<?php

try {
    require "../initialize.php";

    $customerproductvisibility = $oro->customerproductvisibilities->get('1-1-1');

    echo "<b>$customerproductvisibility->type $customerproductvisibility->id</b><br>";
    foreach ($customerproductvisibility->attributes as $key => $val) {
        echo "$key: $val<br>";
    }

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
