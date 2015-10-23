<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 7:28 AM
 */

namespace ZayconTaxify;

class Tag {

	private $string;

	function __construct( $string=NULL )
	{
		if ( $string != NULL )
		{
			$this->setString( $string );
		}
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'string' => Taxify::toString( $this->string )
		);
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
	 *
	 * @return Tag
	 */
	public function setString( $string )
	{
		$this->string = $string;

		return $this;
	}
}