<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:24 AM
 */

namespace ZayconTaxify;

class Account {

	const CALL_GET_CODES = 'GetCodes';

	private $code_type;

	/** @var TaxRequestOption[] $tax_request_options */
	private $tax_request_options;

	/** @var Taxify $taxify */
	private $taxify;

	/** @var Code[] $codes */
	private $codes;

	/**
	 * @param Taxify $taxify
	 */
	function __construct(Taxify &$taxify) {

		$this->taxify = $taxify;
	}

	public function getCodes( $code_type=NULL, array $tax_request_options=NULL )
	{
		if ( $code_type !== NULL )
		{
			$this->setCodeType( $code_type );
		}

		if ( $tax_request_options !== NULL && is_array( $tax_request_options ) )
		{
			$this->setTaxRequestOptions( $tax_request_options );
		}

		$data = array(
			'CodeType' => ($this->code_type === NULL) ? '' : $this->code_type,
			'Options'  => array()
		);

		if ( $this->tax_request_options )
		{
			foreach ( $this->tax_request_options as $tax_request_option )
			{
				$data['Options'][] = array(
					'TaxRequestOption' => array(
						'Key'   => $tax_request_option->getKey(),
						'Value' => $tax_request_option->getValue()
					)
				);
			}
		}

		$communicator = new Communicator( $this->taxify );
		$return = $communicator->call( self::CALL_GET_CODES, $data );

		$this->codes = array();
		$this->setCodeType( $return['CodeType'] );

		foreach ($return['Codes'] as $code)
		{
			$c = new Code( $code );
			$this->codes[] = $c;
		}

		return $this->codes;
	}

	/**
	 * @return mixed
	 */
	public function getCodeType()
	{
		return $this->code_type;
	}

	/**
	 * @param mixed $code_type
	 *
	 * @return Account
	 */
	public function setCodeType( $code_type )
	{
		$this->code_type = $code_type;

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
			$this->tax_request_options[] = $tax_request_option;
		}

		return $this;
	}
}