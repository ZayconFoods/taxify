# ZayconTaxify

[![Latest Stable Version](https://poser.pugx.org/zaycon/taxify/v/stable)](https://packagist.org/packages/zaycon/taxify)
[![Total Downloads](https://poser.pugx.org/zaycon/taxify/downloads)](https://packagist.org/packages/zaycon/taxify)
[![Build Status](https://travis-ci.org/ZayconFoods/taxify.svg?branch=master)](https://travis-ci.org/ZayconFoods/taxify)

Connect your website with the [Taxify](https://www.taxify.co) API

## Table of Contents
* [Installation](#install)
* [Documentation](#documentation)
* [About](#about)

## <a name="install"></a>Installation

Add ZayconTaxify to your `composer.json` file. If you are not using [Composer](http://getcomposer.org), you should be. It's an excellent way to manage dependencies in your PHP application.

```json
{
  "require": {
    "zaycon/taxify": "1.0.*"
  }
}
```

## <a name="documentation"></a>Documentation

### Initialize Your Object

```php
$taxify = new ZayconTaxify\Taxify( '[YOUR_API_KEY]', ZayconTaxify\Taxify::ENV_DEV, TRUE );
```

### Calculate Tax
```php
$origin_address = new ZayconTaxify\Address();
$origin_address
    ->setStreet1( '16201 E Indiana Ave' )
    ->setCity( 'Spokane Valley' )
    ->setState( 'WA' )
    ->setPostalCode( '99216' );

$destination_address = new ZayconTaxify\Address();
$destination_address
    ->setStreet1( '16201 E Indiana Ave' )
    ->setCity( 'Spokane Valley' )
    ->setState( 'WA' )
    ->setPostalCode( '99216' );

$line = new ZayconTaxify\TaxLine();
$line
    ->setQuantity( 1 )
    ->setItemKey( 'SKU001' )
    ->setActualExtendedPrice( 100 )
    ->setItemDescription( 'Some Product' )
    ->setItemTaxabilityCode( ZayconTaxify\Code::CODE_FOOD );

$tax = new ZayconTaxify\Tax( $taxify );
$tax
    ->setDocumentKey( 'Order001' )
    ->setTaxDate( time() )
    ->setIsCommitted( TRUE )
    ->setOriginAddress( $origin_address )
    ->setDestinationAddress( $destination_address )
    ->addLine( $line );
$tax_response = $tax->calculateTax();
```

### Commit Tax
```php
$tax = new ZayconTaxify\Tax( $taxify );
$tax->setDocumentKey( 'Order001' );
$tax_response = $tax->commitTax();
```

### Cancel Tax
```php
$tax = new ZayconTaxify\Tax( $taxify );
$tax->setDocumentKey( 'Order001' );
$tax_response = $tax->cancelTax();
```

### Verify Address
```php
$address = new ZayconTaxify\Address( $taxify );
$address
	->setStreet1( '16201 E Indiana Ave' )
	->setCity( 'Spokane Valley' )
	->setState( 'WA' )
	->setPostalCode( '99216' )
	->verifyAddress();
```

### Get Codes
```php
$account = new ZayconTaxify\Account( $taxify );
$code_types = $account->getCodes();
```

## <a name="about"></a>About
Developed by [Zaycon Fresh](https://www.zayconfresh.com)