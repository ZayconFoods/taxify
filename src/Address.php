<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:23 AM
 */

namespace ZayconTaxify;

class Address extends TaxifyBaseClass {

	const CALL_VERIFY_ADDRESS = 'VerifyAddress';

	const VALIDATION_SUCCESS = 'Validated';
	const VALIDATION_FAILURE = 'NotValidated';

	const ERROR_TAXIFY_OBJ_NOT_PRESENT = 'You must initialize with a Taxify object to perform this call';

	/** @var Taxify $taxify  */
	private $taxify;

	private $first_name;
	private $last_name;
	private $company;
	private $street1;
	private $street2;
	private $city;
	private $region;
	private $postal_code;
	private $county;
	private $country;
	private $email;
	private $phone;
	private $residential_or_business_type;
	private $validation_status;
	private $city_abbreviation;
	private $congressional_district;
	private $county_fips;
	private $time_zone;
	private $time_zone_code;
	private $mail_box_name;
	private $mail_box_number;
	private $post_direction;
	private $pre_direction;
	private $street_name;
	private $street_number;
	private $street_suffix;
	private $suite_name;
	private $suite_number;
	private $is_validated = FALSE;

	/** @var TaxRequestOption[] $tax_request_options */
	private $tax_request_options;

	/** @var Address $original_address */
	private $original_address;

	/** @var Address[] $address_suggestions */
	private $address_suggestions;

	/**
	 * @param Taxify $taxify
	 */
	function __construct ( Taxify &$taxify=NULL )
	{
		$this->taxify = $taxify;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		$data = array(
			'Street1' => Taxify::toString( $this->street1 ),
			'Street2' => Taxify::toString( $this->street2 ),
			'City' => Taxify::toString( $this->city ),
			'Region' => Taxify::toString( $this->region ),
			'PostalCode' => Taxify::toString( $this->postal_code ),
			'Options' => array()
		);

		if ( $this->tax_request_options )
		{
			foreach ( $this->tax_request_options as $tax_request_option )
			{
				$data['Request']['Options'][] = $tax_request_option->toArray();
			}
		}

		return $data;
	}

	/**
	 * @param array $data
	 */
	public function loadFromArray( array $data )
	{
		foreach ( $data as $key => $val )
		{
			if ( $key != 'ExtendedProperties' )
			{
				$method = 'set' . $key;
				if ( method_exists( $this, $method ) )
				{
					$this->$method ( $val );
				}
			}
		}

		if ( array_key_exists( 'ExtendedProperties', $data ) && $data['ExtendedProperties'] !== NULL )
		{
			$this->extended_properties = array();

			foreach ( $data['ExtendedProperties'] as $key => $val )
			{
				$this->extended_properties[] = new ExtendedProperty( $key, $val );
			}
		}
	}

	public function verifyAddress()
	{
		if ( $this->taxify === NULL )
		{
			throw new Exception( self::ERROR_TAXIFY_OBJ_NOT_PRESENT );
		}

		$this->is_validated = FALSE;
		$this->validation_status = NULL;
		$this->original_address = clone $this;
		$this->original_address->clearObjectProperties();

		$communicator = new Communicator( $this->taxify );
		$return = $communicator->call( self::CALL_VERIFY_ADDRESS, $this->toArray() );

		$this->validation_status = ( $return['Address']['ValidationStatus'] == self::VALIDATION_SUCCESS ) ? self::VALIDATION_SUCCESS : self::VALIDATION_FAILURE;
		$this->is_validated = ($this->validation_status == self::VALIDATION_SUCCESS);

		$this
			->setFirstName( $return['Address']['FirstName'] )
			->setLastName( $return['Address']['LastName'] )
			->setCompany( $return['Address']['Company'] )
			->setStreet1( $return['Address']['Street1'] )
			->setStreet2( $return['Address']['Street2'] )
			->setCity( $return['Address']['City'] )
			->setCounty( $return['Address']['County'] )
			->setRegion( $return['Address']['Region'] )
			->setPostalCode( $return['Address']['PostalCode'] )
			->setCountry( $return['Address']['Country'] )
			->setEmail( $return['Address']['Email'] )
			->setPhone( $return['Address']['Phone'] )
			->setResidentialOrBusinessType( $return['Address']['ResidentialOrBusinessType'] );

		/** TODO: Check for AddressSuggestions (need to find an address where this is populated so I can test it first) */
	}

	/**
	 * @return bool
	 */
	public function isValidated()
	{
		return $this->is_validated;
	}

	/**
	 * @return mixed
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}

	/**
	 * @param mixed $first_name
	 *
	 * @return Address
	 */
	public function setFirstName( $first_name )
	{
		$this->first_name = $first_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLastName()
	{
		return $this->last_name;
	}

	/**
	 * @param mixed $last_name
	 *
	 * @return Address
	 */
	public function setLastName( $last_name )
	{
		$this->last_name = $last_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
	 * @param mixed $company
	 *
	 * @return Address
	 */
	public function setCompany( $company )
	{
		$this->company = $company;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStreet1()
	{
		return $this->street1;
	}

	/**
	 * @param mixed $street1
	 *
	 * @return Address
	 */
	public function setStreet1( $street1 )
	{
		$this->street1 = $street1;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStreet2()
	{
		return $this->street2;
	}

	/**
	 * @param mixed $street2
	 *
	 * @return Address
	 */
	public function setStreet2( $street2 )
	{
		$this->street2 = $street2;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param mixed $city
	 *
	 * @return Address
	 */
	public function setCity( $city )
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRegion()
	{
		return $this->region;
	}

	/**
	 * @param mixed $region
	 *
	 * @return Address
	 */
	public function setRegion( $region )
	{
		$this->region = $region;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return $this->region;
	}

	/**
	 * @param $state
	 *
	 * @return $this
	 */
	public function setState( $state )
	{
		$this->setRegion( $state );

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostalCode()
	{
		return $this->postal_code;
	}

	/**
	 * @param mixed $postal_code
	 *
	 * @return Address
	 */
	public function setPostalCode( $postal_code )
	{
		$this->postal_code = $postal_code;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCounty()
	{
		return $this->county;
	}

	/**
	 * @param $county
	 *
	 * @return $this
	 */
	public function setCounty( $county )
	{
		$this->county = $county;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param mixed $country
	 *
	 * @return Address
	 */
	public function setCountry( $country )
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 *
	 * @return Address
	 */
	public function setEmail( $email )
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 *
	 * @return Address
	 */
	public function setPhone( $phone )
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResidentialOrBusinessType()
	{
		return $this->residential_or_business_type;
	}

	/**
	 * @param mixed $residential_or_business_type
	 *
	 * @return Address
	 */
	public function setResidentialOrBusinessType( $residential_or_business_type )
	{
		$this->residential_or_business_type = $residential_or_business_type;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValidationStatus()
	{
		return $this->validation_status;
	}

	/**
	 * @param mixed $validation_status
	 *
	 * @return Address
	 */
	public function setValidationStatus( $validation_status )
	{
		$this->validation_status = $validation_status;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCityAbbreviation()
	{
		return $this->city_abbreviation;
	}

	/**
	 * @param mixed $city_abbreviation
	 *
	 * @return Address
	 */
	public function setCityAbbreviation( $city_abbreviation )
	{
		$this->city_abbreviation = $city_abbreviation;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCongressionalDistrict()
	{
		return $this->congressional_district;
	}

	/**
	 * @param mixed $congressional_district
	 *
	 * @return Address
	 */
	public function setCongressionalDistrict( $congressional_district )
	{
		$this->congressional_district = $congressional_district;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCountyFips()
	{
		return $this->county_fips;
	}

	/**
	 * @param mixed $county_fips
	 *
	 * @return Address
	 */
	public function setCountyFips( $county_fips )
	{
		$this->county_fips = $county_fips;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTimeZone()
	{
		return $this->time_zone;
	}

	/**
	 * @param mixed $time_zone
	 *
	 * @return Address
	 */
	public function setTimeZone( $time_zone )
	{
		$this->time_zone = $time_zone;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTimeZoneCode()
	{
		return $this->time_zone_code;
	}

	/**
	 * @param mixed $time_zone_code
	 *
	 * @return Address
	 */
	public function setTimeZoneCode( $time_zone_code )
	{
		$this->time_zone_code = $time_zone_code;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMailBoxName()
	{
		return $this->mail_box_name;
	}

	/**
	 * @param mixed $mail_box_name
	 *
	 * @return Address
	 */
	public function setMailBoxName( $mail_box_name )
	{
		$this->mail_box_name = $mail_box_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getMailBoxNumber()
	{
		return $this->mail_box_number;
	}

	/**
	 * @param mixed $mail_box_number
	 *
	 * @return Address
	 */
	public function setMailBoxNumber( $mail_box_number )
	{
		$this->mail_box_number = $mail_box_number;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostDirection()
	{
		return $this->post_direction;
	}

	/**
	 * @param mixed $post_direction
	 *
	 * @return Address
	 */
	public function setPostDirection( $post_direction )
	{
		$this->post_direction = $post_direction;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPreDirection()
	{
		return $this->pre_direction;
	}

	/**
	 * @param mixed $pre_direction
	 *
	 * @return Address
	 */
	public function setPreDirection( $pre_direction )
	{
		$this->pre_direction = $pre_direction;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStreetName()
	{
		return $this->street_name;
	}

	/**
	 * @param mixed $street_name
	 *
	 * @return Address
	 */
	public function setStreetName( $street_name )
	{
		$this->street_name = $street_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStreetNumber()
	{
		return $this->street_number;
	}

	/**
	 * @param mixed $street_number
	 *
	 * @return Address
	 */
	public function setStreetNumber( $street_number )
	{
		$this->street_number = $street_number;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStreetSuffix()
	{
		return $this->street_suffix;
	}

	/**
	 * @param mixed $street_suffix
	 *
	 * @return Address
	 */
	public function setStreetSuffix( $street_suffix )
	{
		$this->street_suffix = $street_suffix;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSuiteName()
	{
		return $this->suite_name;
	}

	/**
	 * @param mixed $suite_name
	 *
	 * @return Address
	 */
	public function setSuiteName( $suite_name )
	{
		$this->suite_name = $suite_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSuiteNumber()
	{
		return $this->suite_number;
	}

	/**
	 * @param mixed $suite_number
	 *
	 * @return Address
	 */
	public function setSuiteNumber( $suite_number )
	{
		$this->suite_number = $suite_number;

		return $this;
	}

	/**
	 * @return Address[]
	 */
	public function getAddressSuggestions()
	{
		return $this->address_suggestions;
	}

	/**
	 * @param Address[] $address_suggestions
	 *
	 * @return Address
	 */
	public function setAddressSuggestions( $address_suggestions )
	{
		$this->address_suggestions = $address_suggestions;

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
	 *
	 */
	public function clearObjectProperties()
	{
		$this->original_address = NULL;
		$this->address_suggestions = NULL;
		$this->tax_request_options = NULL;
		$this->extended_properties = NULL;
	}
}