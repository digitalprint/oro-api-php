<?php

try {
    require "../initialize.php";

    $userroles = $oro->userroles->page(1, 5);

    echo '<ul>';
    foreach ($userroles as $userrole) {
        echo '<li>';
        echo '<b>' . $userrole->type . ' ' . $userrole->id . '</b><br>';
        foreach ($userrole->attributes as $key => $val) {
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
