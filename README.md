# ZayconTaxify
Connect your website with Taxify's API

## Table of Contents
* [Install](#install)
* [Documentation](#documentation)
* [About](#about)

## <a name="install"></a>Install
Coming Soon
## <a name="documentation"></a>Documentation

### Initialize Your Object

```php
$taxify = new ZayconTaxify\Taxify( API_KEY, ZayconTaxify\Taxify::ENV_DEV, TRUE );
```

### Calculate Tax
```
$tax = new ZayconTaxify\Tax( $taxify );
$tax
    ->setDocumentKey( 'Order001' )
    ->setTaxDate( time() )
    ->setIsCommitted( TRUE )
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
$code_types = $account->getCodes( 'Item' );
```

## <a name="about"></a>About
Developed by [Zaycon Fresh](https://www.zayconfresh.com)