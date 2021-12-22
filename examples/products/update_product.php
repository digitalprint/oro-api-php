<?php

  require "../initialize.php";

  $products = $oro->products->get(['id' => 104]);

  echo $products[0]->id . "<br>";
  echo $products[0]->attributes->status . "<br>";

  $status = 'disabled';
  if ($products[0]->attributes->status === 'disabled') {
      $status = 'enabled';
  }

  $res = $products[0]->update([
      'data' => [
        'meta' => [
          'update' => true,
        ],
        'type' => 'products',
        'id' => $products[0]->id,
        'attributes' => [
          'status' => $status,
        ],
      ],
    ]);

  $products = $oro->products->get(['id' => 104]);
  echo $products[0]->attributes->status . "<br>";
