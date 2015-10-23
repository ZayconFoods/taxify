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
}
catch ( ZayconTaxify\Exception $e )
{
	var_dump( $e );
}