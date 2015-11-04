<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:10 AM
 */

namespace ZayconTaxify;

class Exception extends \Exception {

	function __construct( $message, $code=0, \Exception $previous=NULL) {

		parent::__construct( $message, $code, $previous );
	}
}