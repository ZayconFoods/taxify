<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 3:08 PM
 */

namespace ZayconTaxify;

class TaxResponse extends TaxifyBaseClass {

	private $document_key;
	private $sales_tax_amount;
	private $tax_jurisdiction_summary;
	private $response_status;
	private $effective_tax_date;
	private $is_committed = FALSE;
	private $effective_tax_address_type;
	private $raw_json;

	/** @var Address $destination_address */
	private $destination_address;

	/** @var Address $origin_address */
	private $origin_address;

	/** @var Address $effective_tax_address */
	private $effective_tax_address;

	/** @var TaxJurisdiction[] $tax_jurisdictions */
	private $tax_jurisdictions;

	/** @var TaxLine[] $tax_lines */
	private $lines;

	/**
	 * @param null $json
	 */
	function __construct( $json=NULL )
	{
		if ( $json !== NULL )
		{
			$this->loadFromJson( $json );
		}
	}

	/**
	 * @param $json
	 */
	public function loadFromJson( $json )
	{
		$this->raw_json = $json;
		$this->loadFromArray( json_decode( $json, TRUE ) );
	}

	/**
	 * @param array $data
	 */
	public function loadFromArray( array $data )
	{
		var_dump($data);

		$this
			->setDocumentKey( $data['DocumentKey'] )
			->setSalesTaxAmount( $data['SalesTaxAmount'] )
			->setTaxJurisdictionSummary( $data['TaxJurisdictionSummary'] )
			->setResponseStatus( $data['ResponseStatus'] )
			->setEffectiveTaxDate( $data['EffectiveTaxDate'] )
			->setIsCommitted( $data['IsCommitted'] )
			->setEffectiveTaxAddressType( $data['EffectiveTaxAddressType'] )
			->setExtendedProperties( $data['ExtendedProperties'] );

		$this->destination_address = new Address();
		$this->destination_address->loadFromArray( $data['DestinationAddress'] );

		$this->origin_address = new Address();
		$this->origin_address->loadFromArray( $data['OriginAddress'] );

		$this->effective_tax_address = new Address();
		$this->effective_tax_address->loadFromArray( $data['EffectiveTaxAddress'] );

		if ( ! empty( $data['TaxJurisdictionDetails'] ) )
		{
			$this->tax_jurisdictions = array();

			foreach ( $data['TaxJurisdictionDetails'] as $detail )
			{
				$this->tax_jurisdictions[] = new TaxJurisdiction( $detail );
			}
		}

		if ( ! empty( $data['TaxLineDetails'] ) )
		{
			$this->lines = array();

			foreach ( $data['TaxLineDetails'] as $detail )
			{
				$this->lines[] = new TaxLine( $detail );
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getDocumentKey()
	{
		return $this->document_key;
	}

	/**
	 * @param mixed $document_key
	 *
	 * @return TaxResponse
	 */
	public function setDocumentKey( $document_key )
	{
		$this->document_key = $document_key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSalesTaxAmount()
	{
		return $this->sales_tax_amount;
	}

	/**
	 * @param mixed $sales_tax_amount
	 *
	 * @return TaxResponse
	 */
	public function setSalesTaxAmount( $sales_tax_amount )
	{
		$this->sales_tax_amount = $sales_tax_amount;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTaxJurisdictionSummary()
	{
		return $this->tax_jurisdiction_summary;
	}

	/**
	 * @param mixed $tax_jurisdiction_summary
	 *
	 * @return TaxResponse
	 */
	public function setTaxJurisdictionSummary( $tax_jurisdiction_summary )
	{
		$this->tax_jurisdiction_summary = $tax_jurisdiction_summary;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResponseStatus()
	{
		return $this->response_status;
	}

	/**
	 * @param mixed $response_status
	 *
	 * @return TaxResponse
	 */
	public function setResponseStatus( $response_status )
	{
		$this->response_status = $response_status;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEffectiveTaxDate()
	{
		return $this->effective_tax_date;
	}

	/**
	 * @param mixed $effective_tax_date
	 *
	 * @return TaxResponse
	 */
	public function setEffectiveTaxDate( $effective_tax_date )
	{
		$this->effective_tax_date = $effective_tax_date;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isIsCommitted()
	{
		return $this->is_committed;
	}

	/**
	 * @param boolean $is_committed
	 *
	 * @return TaxResponse
	 */
	public function setIsCommitted( $is_committed )
	{
		$this->is_committed = ($is_committed === TRUE) ? TRUE : FALSE;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEffectiveTaxAddressType()
	{
		return $this->effective_tax_address_type;
	}

	/**
	 * @param mixed $effective_tax_address_type
	 *
	 * @return TaxResponse
	 */
	public function setEffectiveTaxAddressType( $effective_tax_address_type )
	{
		$this->effective_tax_address_type = $effective_tax_address_type;

		return $this;
	}

	/**
	 * @param bool|FALSE $as_array
	 *
	 * @return mixed
	 */
	public function getRawJson( $as_array=FALSE )
	{
		if ($as_array)
		{
			return json_decode( $this->raw_json, TRUE );
		}

		return $this->raw_json;
	}
}