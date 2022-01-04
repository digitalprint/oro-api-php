<?php

try {
    require "../initialize.php";

    $user = $oro->users->get(11);
    
    echo '<b>' . $user->type . ' ' . $user->id . '</b><br>';
    foreach ($user->attributes as $key => $val) {
        if (is_array($val)) {
            echo $key . ': ' . implode(', ', $val) . '<br>';
        } else {
            echo "{$key}: {$val}<br>";
        }
    }
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
