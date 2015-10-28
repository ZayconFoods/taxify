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

	/* tax */
	$tax = new ZayconTaxify\Tax( $taxify );
	$tax->setDocumentKey( 'Order001' );
	$tax_response = $tax->commitTax();

	var_dump( $tax_response );
}
catch ( ZayconTaxify\Exception $e )
{
	var_dump( $e );
}