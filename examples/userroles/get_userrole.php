<?php

try {
    require "../initialize.php";

    $userrole = $oro->userroles->get(10);

    echo '<b>' . $userrole->type . ' ' . $userrole->id . '</b><br>';
    foreach ($userrole->attributes as $key => $val) {
        if (is_array($val)) {
            echo $key . ': ' . implode(', ', $val) . '<br>';
        } else {
            echo "{$key}: {$val}<br>";
        }
    }
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
