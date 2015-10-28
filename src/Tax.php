<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:23 AM
 */

namespace ZayconTaxify;

class Tax {

	const CALL_CALCULATE_TAX = 'CalculateTax';
	const CALL_CANCEL_TAX = 'CancelTax';
	const CALL_COMMIT_TAX = 'CommitTax';

	const TAX_CODE_NON_TAXABLE = 'non';
	const TAX_CODE_MEAL = 'meal';

	const ERROR_NO_LINES = 'You must assign at least one Tax Request Line';
	const ERROR_NO_DESTINATION_ADDRESS = 'You must assign a Destination Address';
	const ERROR_NO_DOCUMENT_KEY = 'You must assign a Document Key';

	/** @var Taxify $taxify */
	private $taxify;

	private $document_key;
	private $committed_document_key;
	private $tax_date;
	private $is_committed = FALSE;
	private $customer_key;
	private $customer_taxability_code;
	private $customer_registration_number;

	/** @var Address $destination_address */
	private $destination_address;

	/** @var Address $origin_address */
	private $origin_address;

	/** @var TaxRequestOption[] $tax_request_options */
	private $tax_request_options;

	/** @var Tag[] $tags */
	private $tags;

	/** @var Discount[] $discounts */
	private $discounts;

	/** @var TaxLine[] $lines */
	private $lines;

	/**
	 * @param Taxify $taxify
	 * @param null $document_key
	 * @param null $tax_date
	 */
	function __construct( Taxify &$taxify, $document_key=NULL, $tax_date=NULL )
	{
		$this->taxify = $taxify;
		$this
			->setDocumentKey( $document_key )
			->setTaxDate( $tax_date );
	}

	public function calculateTax()
	{
		if ( !$this->hasLines() )
		{
			throw new Exception ( self::ERROR_NO_LINES );
		}

		if ( !$this->hasDestinationAddress() )
		{
			throw new Exception ( self::ERROR_NO_DESTINATION_ADDRESS );
		}

		if ( empty( $this->document_key ) )
		{
			throw new Exception ( self::ERROR_NO_DOCUMENT_KEY );
		}

		$data = array(
			'DocumentKey' => Taxify::toString( $this->document_key ),
			'TaxDate' => ( empty( $this->tax_date ) ) ? date('Y-m-d') : $this->tax_date,
			'IsCommitted' => $this->is_committed,
			'CustomerKey' => Taxify::toString( $this->customer_key ),
			'CustomerTaxabilityCode' => Taxify::toString( $this->customer_taxability_code ),
			'CustomerRegistrationNumber' => Taxify::toString( $this->customer_registration_number ),
			'DestinationAddress' => $this->destination_address->toArray(),
			'Lines' => array(),
			'Options' => array(),
			'Tags' => array(),
			'Discounts' => array()
		);

		if ( $this->origin_address !== NULL )
		{
			$data['OriginAddress'] = $this->origin_address->toArray();
		}

		foreach( $this->lines as $line )
		{
			$data['Lines'][] = $line->toArray();
		}

		if ( ! empty($this->tax_request_options) )
		{
			foreach ( $this->tax_request_options as $tax_request_option )
			{
				$data['Options'][] = $tax_request_option->toArray();
			}
		}

		if ( ! empty($this->tags) )
		{
			foreach ( $this->tags as $tag )
			{
				$data['Tags'][] = $tag->toArray();
			}
		}

		if ( ! empty($this->discounts) )
		{
			foreach ( $this->discounts as $discount )
			{
				$data['Discounts'][] = $discount->toArray();
			}
		}

		$communicator = new Communicator( $this->taxify );
		$return = $communicator->call( self::CALL_CALCULATE_TAX, $data );
		return new TaxResponse( json_encode( $return ) );
	}

	public function cancelTax()
	{
		if ( empty( $this->document_key ) )
		{
			throw new Exception ( self::ERROR_NO_DOCUMENT_KEY );
		}

		$data = array(
			'DocumentKey' => Taxify::toString( $this->document_key )
		);

		$communicator = new Communicator( $this->taxify );
		$return = $communicator->call( self::CALL_CANCEL_TAX, $data );
		$tax_response =  new TaxResponse;
		$tax_response->setResponseStatus( 1 );
		$tax_response->setExtendedProperties( $return['ExtendedProperties'] );

		return $tax_response;
	}

	public function commitTax()
	{
		if ( empty( $this->document_key ) )
		{
			throw new Exception ( self::ERROR_NO_DOCUMENT_KEY );
		}

		$data = array(
			'DocumentKey' => Taxify::toString( $this->document_key ),
			'CommitedDocumentKey' => Taxify::toString( $this->committed_document_key )
		);

		$communicator = new Communicator( $this->taxify );
		$return = $communicator->call( self::CALL_COMMIT_TAX, $data );
		$tax_response =  new TaxResponse;
		$tax_response->setResponseStatus( 1 );
		$tax_response->setExtendedProperties( $return['ExtendedProperties'] );

		return $tax_response;
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
	 * @return Tax
	 */
	public function setDocumentKey( $document_key )
	{
		$this->document_key = $document_key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCommittedDocumentKey()
	{
		return $this->committed_document_key;
	}

	/**
	 * @param mixed $committed_document_key
	 *
	 * @return Tax
	 */
	public function setCommittedDocumentKey( $committed_document_key )
	{
		$this->committed_document_key = $committed_document_key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTaxDate()
	{
		return $this->tax_date;
	}

	/**
	 * @param mixed $tax_date
	 *
	 * @return Tax
	 */
	public function setTaxDate( $tax_date )
	{
		if ( $tax_date === NULL || strlen( $tax_date ) == 0 )
		{
			$this->tax_date = NULL;
		}
		elseif ( is_numeric( $tax_date ) )
		{
			$this->tax_date = date( 'Y-m-d', $tax_date );
		}
		else
		{
			$this->tax_date = date( 'Y-m-d', strtotime( $tax_date ) );
		}

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
	 * @return Tax
	 */
	public function setIsCommitted( $is_committed )
	{
		$this->is_committed = $is_committed;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCustomerKey()
	{
		return $this->customer_key;
	}

	/**
	 * @param mixed $customer_key
	 *
	 * @return Tax
	 */
	public function setCustomerKey( $customer_key )
	{
		$this->customer_key = $customer_key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCustomerTaxabilityCode()
	{
		return $this->customer_taxability_code;
	}

	/**
	 * @param mixed $customer_taxability_code
	 *
	 * @return Tax
	 */
	public function setCustomerTaxabilityCode( $customer_taxability_code )
	{
		$this->customer_taxability_code = $customer_taxability_code;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCustomerRegistrationNumber()
	{
		return $this->customer_registration_number;
	}

	/**
	 * @param mixed $customer_registration_number
	 *
	 * @return Tax
	 */
	public function setCustomerRegistrationNumber( $customer_registration_number )
	{
		$this->customer_registration_number = $customer_registration_number;

		return $this;
	}

	/**
	 * @return Address
	 */
	public function getDestinationAddress()
	{
		return $this->destination_address;
	}

	/**
	 * @param Address $destination_address
	 *
	 * @return Tax
	 */
	public function setDestinationAddress( Address $destination_address )
	{
		$this->destination_address = $destination_address;

		return $this;
	}

	/**
	 * @return Address
	 */
	public function getOriginAddress()
	{
		return $this->origin_address;
	}

	/**
	 * @param Address $origin_address
	 *
	 * @return Tax
	 */
	public function setOriginAddress( Address $origin_address )
	{
		$this->origin_address = $origin_address;

		return $this;
	}

	/**
	 * @return TaxRequestOption[]
	 */
	public function getTaxRequestOptions()
	{
		return $this->tax_request_options;
	}

	/**
	 * @param array $tax_request_options
	 *
	 * @return $this
	 */
	public function setTaxRequestOptions( array $tax_request_options )
	{

		$this->tax_request_options = array();
		foreach ($tax_request_options as $key => $value)
		{
			$tax_request_option = new TaxRequestOption( $key, $value );
			$this->addTaxRequestOption( $tax_request_option );
		}

		return $this;
	}

	/**
	 * @param TaxRequestOption $tax_request_option
	 */
	public function addTaxRequestOption( TaxRequestOption $tax_request_option )
	{
		$this->tax_request_options[] = $tax_request_option;
	}

	/**
	 * @param $index
	 */
	public function removeTaxRequestOption( $index )
	{
		if ( array_key_exists( $index, $this->tax_request_options ) )
		{
			unset( $this->tax_request_options[$index] );
		}
	}

	/**
	 *
	 */
	public function removeAllTaxRequestOptions()
	{
		$this->tax_request_options = NULL;
	}

	/**
	 * @return Tag[]
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * @param array $tags
	 *
	 * @return $this
	 */
	public function setTags( array $tags )
	{
		$this->tags = array();
		foreach ($tags as $string)
		{
			$tag = new Tag( $string );
			$this->tags[] = $tag;
		}

		return $this;
	}

	/**
	 * @param Tag $tag
	 */
	public function addTag( Tag $tag )
	{
		$this->tags[] = $tag;
	}

	/**
	 * @param $index
	 */
	public function removeTag( $index )
	{
		if ( array_key_exists( $index, $this->tags ) )
		{
			unset( $this->tags[$index] );
		}
	}

	/**
	 *
	 */
	public function removeAllTags()
	{
		$this->tags = NULL;
	}

	/**
	 * @return Discount[]
	 */
	public function getDiscounts()
	{
		return $this->discounts;
	}

	/**
	 * @param Discount $discount
	 */
	public function addDiscount( Discount $discount )
	{
		$this->discounts[] = $discount;
	}

	/**
	 * @param $index
	 */
	public function removeDiscount( $index )
	{
		if ( array_key_exists( $index, $this->discounts ) )
		{
			unset( $this->discounts[$index] );
		}
	}

	/**
	 *
	 */
	public function removeAllDiscounts()
	{
		$this->discounts = NULL;
	}

	/**
	 * @return TaxLine[]
	 */
	public function getLines()
	{
		return $this->lines;
	}

	/**
	 * @param TaxLine $line
	 */
	public function addLine( TaxLine $line )
	{
		if ($this->getLineCount() == 0)
		{
			$this->lines = array();
		}

		$this->lines[] = $line;
	}

	/**
	 * @param $index
	 */
	public function removeLine( $index )
	{
		if ( array_key_exists( $index, $this->lines ) )
		{
			unset( $this->lines[$index] );
		}
	}

	/**
	 *
	 */
	public function removeAllLines()
	{
		$this->lines = NULL;
	}

	/**
	 * @return int
	 */
	public function getLineCount()
	{
		return ( $this->lines === NULL ) ? 0 : count( $this->lines );
	}

	/**
	 * @return bool
	 */
	public function hasLines()
	{
		return ( $this->lines === NULL or count( $this->lines ) == 0 ) ? FALSE : TRUE;
	}

	/**
	 * @return bool
	 */
	public function hasDestinationAddress()
	{
		return ( $this->destination_address === NULL ) ? FALSE : TRUE;
	}
}