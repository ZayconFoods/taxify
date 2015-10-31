<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 1:52 PM
 */

namespace ZayconTaxify;

class Code {

	/** You account codes may be different, these are just the defaults */
	const CODE_CLOTHING = 'CLOTHING';
	const CODE_FOOD = 'FOOD';
	const CODE_FREIGHT = 'FREIGHT';
	const CODE_NONTAX = 'NONTAX';
	const CODE_TAXABLE = 'TAXABLE';
	const CODE_WINE = 'WINE';

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