# ZayconTaxify
Connect your website with Taxify's API

Version 1.0.0.0

## Table of Contents
* [Install](#install)
* [Documentation](#documentation)
* [About](#about)

## <a name="install"></a>Install
Coming Soon
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
	->setStreet1( '1234 Awesome St' ) /* should change St to Ave */
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