<?php

try {
    require "../initialize.php";

    $addresstypes = $oro->addresstypes->page();

    echo '<ul>';
    foreach ($addresstypes as $addresstype) {
        echo '<li>';
        echo "<b>$addresstype->type $addresstype->id</b><br>";
        foreach ($addresstype->attributes as $key => $val) {
            echo "$key: $val<br>";
        }
        echo "</li>";
    }
    echo '</ul>';
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
