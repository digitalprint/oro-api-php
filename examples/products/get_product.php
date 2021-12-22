<?php

    require "../initialize.php";

    $products = $oro->products->get(['id' => 104]);

    foreach ($products as $product) {
        echo $product->id . "<br>";
        echo $product->type;
    }
