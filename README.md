# OroCommerce API PHP Client

Thank you for using the "OroCommerce Api PHP Client" (Digitalprint_Oro-Api-PHP).

This package contains some basic functions you need to connect php applications with your OroCommerce system. 

This package contains only a few endpoints. If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".

[![Latest Stable Version](http://poser.pugx.org/digitalprint/oro-api-php/v)](https://packagist.org/packages/digitalprint/oro-api-php) [![Total Downloads](http://poser.pugx.org/digitalprint/oro-api-php/downloads)](https://packagist.org/packages/digitalprint/oro-api-php)

## 1. Documentation

- [Contribute on Github](https://github.com/digitalprint/oro-api-php)
- [Releases](https://github.com/digitalprint/oro-api-php/releases)
- [API Developer Guide](https://doc.oroinc.com/backend/api/)

## 2. How to install

### Install via composer (recommend)

Run the following command in your root folder:

```
composer require digitalprint/oro-api-php
```

## 3. User Guide

This package integrates OroCommerce API functions into your php application.

### 3.1 Getting started

Initializing the OroCommerce API client.

```php
$oro = new \Digitalprint\Oro\Api\OroApiClient();
$oro->setApiEndpoint('YOUR_ORO_API_ENDPOINT');
$oro->setUser('YOUR_ORO_API_USER');

$res = $oro->authorization->create([
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
]);

$oro->setAccessToken($res->access_token);
``` 

### 3.2 Product Examples

#### Get a single product
```php
$product = $oro->products->get(100);
``` 

#### Get a list of products
```php
$products = $oro->products->page();
``` 

#### Get a list of featured products
```php
$products = $oro->products->page(1, 10, ['featured' => true]);
```

#### Get names of a product
```php
$names = $oro->products->get(100)->names();
``` 

#### Update an existing product
```php
$product = $oro->products->get(100);

$res = $product->update([
  'data' => [
    'meta' => [
      'update' => true,
    ],
    'type' => 'products',
    'id' => $product->id,
    'attributes' => [
      'status' => ($product->attributes->status === 'disabled' ? "enabled" : "disabled"),
    ],
  ],
]);
``` 

#### Create a new product
```php
$product = $oro->products->create([
  'data' => [
    'type' => 'products',
    'attributes' => [
      'sku' => 'test-api-' . strtotime('now'),
      'status' => 'enabled',
      'variantFields' => [],
      'productType' => 'simple',
      'featured' => true,
      'newArrival' => false,
      'availability_date' => '2018-01-01',
    ],
    'relationships' => [ ... ],
  ],
  'included' => [ ... ],
]);
``` 

#### Delete a single product
```php
$names = $oro->products->get(100)->delete();
``` 
### 3.3 More Examples

More examples are in the [examples folder](examples)


