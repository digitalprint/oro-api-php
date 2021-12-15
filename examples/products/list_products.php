<?php

    require "../initialize.php";

    $products = $oro->products->page(3);

    foreach ($products as $product) {
        echo $product->id . "<br>";
        echo $product->type . "<br>";
    }

    $products = $products->next();

    foreach ($products as $product) {
        echo $product->id . "<br>";
        echo $product->type . "<br>";
    }
