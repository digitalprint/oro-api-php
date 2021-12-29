<?php

try {
    require "../initialize.php";

    $addresses = $oro->addresses->page();

    echo '<ul>';
    foreach ($addresses as $address) {
        echo '<li>';
        echo "<b>{$address->type} {$address->id}</b><br>";
        foreach ($address->attributes as $key => $val) {
            echo "{$key}: {$val}<br>";
        }
        echo "</li>";
    }
    echo '</ul>';

} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
