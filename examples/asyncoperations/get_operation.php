<?php

  require "../initialize.php";

  $operation = $oro->asyncoperations->get(12);

  echo "<pre>";
  print_r($operation);
  echo "</pre>";
  