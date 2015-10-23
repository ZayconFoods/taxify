<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 2:13 PM
 */

require_once( 'config.php' );

try
{
	/* initialize taxify */
	$taxify = new ZayconTaxify\Taxify( API_KEY, ZayconTaxify\Taxify::ENV_DEV, TRUE );

	/* address */
	$address = new ZayconTaxify\Address( $taxify );
	$address
		->setStreet1( '16201 E Indiana St' ) /* should change St to Ave */
		->setCity( 'Spokane Valley' )
		->setState( 'WA' )
		->setPostalCode( '99216' )
		->verifyAddress();

	var_dump( $address );
}
catch ( ZayconTaxify\Exception $e )
{
	var_dump( $e );
}