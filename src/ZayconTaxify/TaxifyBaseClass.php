<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/27/15
 * Time: 9:07 AM
 */

namespace ZayconTaxify;

class TaxifyBaseClass {

	/** @var ExtendedProperty[] $extended_properties */
	protected $extended_properties;

	/**
	 * @param array|NULL $data
	 */
	public function setExtendedProperties( array $data=NULL )
	{
		if ( ! empty( $data ) )
		{
			$this->extended_properties = array();

			foreach ($data as $key => $val)
			{
				$this->extended_properties[] = new ExtendedProperty( $key, $val );
			}
		}
	}

	/**
	 * @return ExtendedProperty[]
	 */
	public function getExtendedProperties()
	{
		return $this->extended_properties;
	}

	/**
	 *
	 */
	public function clearExtendedProperties()
	{
		$this->extended_properties = NULL;
	}

	/**
	 * @param $key
	 * @param $val
	 */
	public function addExtendedProperty( $key, $val )
	{
		if ( $this->extended_properties === NULL )
		{
			$this->extended_properties = array();
		}
		$this->extended_properties[] = new ExtendedProperty( $key, $val );
	}

	/**
	 * @param $index
	 */
	public function removeExtendedProperty( $index )
	{
		if ( $this->extended_properties !== NULL )
		{
			if ( array_key_exists( $index, $this->extended_properties ) )
			{
				unset( $this->extended_properties[ $index ] );
			}
		}
	}
}