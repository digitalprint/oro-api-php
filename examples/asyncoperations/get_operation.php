<?php

try {
    require "../initialize.php";

    $operation = $oro->asyncoperations->get(12);

    echo "<b>{$operation->type} {$operation->id}</b><br>";
    foreach ($operation->attributes as $key => $val) {
        if (is_array($val)) {
            echo $key . ': ' . implode(', ', $val) . '<br>';
        } else {
            echo "{$key}: {$val}<br>";
        }
    }
} catch (\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: {$e->getMessage()}";
}
