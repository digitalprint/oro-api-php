<?php

try {
    require "../initialize.php";

    $users = $oro->users->page();

    echo '<ul>';
    foreach ($users as $user) {
        echo '<li>';
        echo '<b>' . $user->type . ' ' . $user->id . '</b><br>';
        foreach ($user->attributes as $key => $val) {
            if (is_array($val)) {
                echo $key . ': ' . implode(', ', $val) . '<br>';
            } else {
                echo "$key: $val<br>";
            }
        }
        echo "</li>";
    }
    echo '</ul>';

} catch (\Digitalprint\Oro\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . $e->getMessage();
}
