<?php

    require "../initialize.php";

    $products = $oro->products->get(1);

    echo $products->data->id . "<br>";
    echo $products->data->type;
