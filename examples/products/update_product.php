<?php

  require "../initialize.php";

  $products = $oro->products->get(['id' => 104]);

  echo $products[0]->id . "<br>";
  echo $products[0]->attributes->status . "<br>";

  $res = $products[0]->update([
      'data' => [
        'type' => 'products',
        'attributes' => [
          'status' => 'disabled',
        ],
      ],
    ]);

  $products = $oro->products->get(['id' => 104]);
  echo $products[0]->attributes->status . "<br>";
