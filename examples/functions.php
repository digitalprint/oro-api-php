<?php
/*
 * NOTE: The examples are using a text file as a database.
 * Please use a real database like MySQL in production code.
 */

function database_read($orderId)
{
    $orderId = (int)$orderId;
    $database = __DIR__ . "/database/order-$orderId.txt";

    $status = @file_get_contents($database);

    return $status ?: "unknown order";
}

function database_write($orderId, $status)
{
    $orderId = (int)$orderId;
    $database = __DIR__ . "/database/order-$orderId.txt";

    file_put_contents($database, $status);
}
