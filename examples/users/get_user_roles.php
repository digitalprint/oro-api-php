<?php

try {
    require "../initialize.php";

    $user = $oro->users->get(11);
    
    echo '<b>' . $user->type . ' ' . $user->id . '</b><br>';

    $roles = $user->roles();

    foreach ($roles as $role) {
        foreach ($role->attributes as $key => $val) {
            echo "$key: $val<br>";
        }
    }
} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
