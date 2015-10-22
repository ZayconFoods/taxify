<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 1:52 PM
 */

namespace ZayconTaxify;

class Code {

	private $string;

	/**
	 * @param $string
	 */
	function __construct( $string )
	{
		$this->setString( $string );
	}

	/**
	 * @return mixed
	 */
	public function getString()
	{
		return $this->string;
	}

	/**
	 * @param mixed $string
	 */
	public function setString( $string )
	{
		$this->string = $string;
	}
}