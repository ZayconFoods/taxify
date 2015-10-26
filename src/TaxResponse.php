<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 3:08 PM
 */

namespace ZayconTaxify;

class TaxResponse {

	private $document_key;
	private $sales_tax_amount;
	private $tax_jurisdiction_summary;

	/** @var Address $destination_address */
	private $destination_address;

	/** @var Address $origin_address */
	private $origin_address;

	/** @var TaxJurisdiction[] $tax_jurisdictions */
	private $tax_jurisdictions;

	/** @var TaxLine[] $tax_lines */
	private $lines;

	/** @var ExtendedProperty[] $extended_properties */
	private $extended_properties;

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
		$this->loadFromArray( json_decode( $json, TRUE ) );
	}

	/**
	 * @param array $data
	 */
	public function loadFromArray( array $data )
	{

	}
}