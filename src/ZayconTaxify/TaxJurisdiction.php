<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 3:10 PM
 */

namespace ZayconTaxify;

class TaxJurisdiction extends TaxifyBaseClass {

	private $applied_to;
	private $jurisdiction_type;
	private $jurisdiction_name;
	private $jurisdiction_tax_rate;
	private $jurisdiction_tax_amount;

	/**
	 * @param array|NULL $data
	 */
	function __construct( array $data=NULL )
	{
		if ( ! empty( $data ) )
		{
			$this->loadFromArray( $data );
		}
	}

	/**
	 * @param array $data
	 */
	public function loadFromArray( array $data )
	{
		$this
			->setAppliedTo( $data['AppliedTo'] )
			->setJurisdictionType( $data['JurisdictionType'] )
			->setJurisdictionName( $data['JurisdictionName'] )
			->setJurisdictionTaxRate( $data['JurisdictionTaxRate'] )
			->setJurisdictionTaxAmount( $data['JurisdictionTaxAmount'] )
			->setExtendedProperties( $data['ExtendedProperties'] );
	}

	/**
	 * @return mixed
	 */
	public function getAppliedTo()
	{
		return $this->applied_to;
	}

	/**
	 * @param mixed $applied_to
	 *
	 * @return TaxJurisdiction
	 */
	public function setAppliedTo( $applied_to )
	{
		$this->applied_to = $applied_to;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getJurisdictionType()
	{
		return $this->jurisdiction_type;
	}

	/**
	 * @param mixed $jurisdiction_type
	 *
	 * @return TaxJurisdiction
	 */
	public function setJurisdictionType( $jurisdiction_type )
	{
		$this->jurisdiction_type = $jurisdiction_type;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getJurisdictionName()
	{
		return $this->jurisdiction_name;
	}

	/**
	 * @param mixed $jurisdiction_name
	 *
	 * @return TaxJurisdiction
	 */
	public function setJurisdictionName( $jurisdiction_name )
	{
		$this->jurisdiction_name = $jurisdiction_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getJurisdictionTaxRate()
	{
		return $this->jurisdiction_tax_rate;
	}

	/**
	 * @param mixed $jurisdiction_tax_rate
	 *
	 * @return TaxJurisdiction
	 */
	public function setJurisdictionTaxRate( $jurisdiction_tax_rate )
	{
		$this->jurisdiction_tax_rate = $jurisdiction_tax_rate;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getJurisdictionTaxAmount()
	{
		return $this->jurisdiction_tax_amount;
	}

	/**
	 * @param mixed $jurisdiction_tax_amount
	 *
	 * @return TaxJurisdiction
	 */
	public function setJurisdictionTaxAmount( $jurisdiction_tax_amount )
	{
		$this->jurisdiction_tax_amount = $jurisdiction_tax_amount;

		return $this;
	}

}