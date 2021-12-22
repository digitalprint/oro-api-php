<?php

    require "../initialize.php";

    $products = $oro->products->delete(['id' => 104]);

    $products = $oro->products->get(['id' => 104]);
    $products[0]->delete();


