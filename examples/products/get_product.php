<?php

    require "../initialize.php";

    $products = $oro->products->get(1);

    echo $products->id . "<br>";
    echo $products->type;
