<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:45 AM
 */

namespace ZayconTaxify;

class TaxRequestOption {

	private $key;
	private $value;

	/**
	 * @param $key
	 * @param $value
	 */
	function __construct( $key, $value )
	{
		$this->setKey( $key );
		$this->setValue( $value );
	}

	/**
	 * @return mixed
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param mixed $key
	 *
	 * @return TaxRequestOption
	 */
	public function setKey( $key )
	{
		$this->key = $key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param mixed $value
	 *
	 * @return TaxRequestOption
	 */
	public function setValue( $value )
	{
		$this->value = $value;

		return $this;
	}
}