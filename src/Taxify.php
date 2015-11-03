<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 10:31 AM
 */

namespace ZayconTaxify;

class Taxify {

	const VERSION = '1.0.0';

	const DEV_URL = 'https://ws-test.shipcompliant.com/taxify/1.1/core/JSONservice.asmx/';
	const PROD_URL = 'https://ws.taxify.co/taxify/1.1/core/JSONService.asmx/';
	const ENV_DEV = 'DEV';
	const ENV_PROD = 'PROD';

	private $environment;
	private $url;
	private $api_key;
	private $debug_mode = FALSE;

	/**
	 * @param null $api_key
	 * @param null $environment
	 * @param bool|FALSE $debug_mode
	 */
	function __construct( $api_key=NULL, $environment=NULL, $debug_mode=FALSE ) {

		if ( $api_key !== NULL )
		{
			$this->setApiKey( $api_key );
		}

		$this->setDebugMode( $debug_mode );
		$this->environment = ( $environment == self::ENV_PROD ) ? self::ENV_PROD : self::ENV_DEV;
		$this->url = ( $this->isProd() ) ? self::PROD_URL : self::DEV_URL;
	}

	/**
	 * @return bool
	 */
	public function isProd()
	{
		return $this->environment == self::ENV_PROD;
	}

	/**
	 * @return bool
	 */
	public function isDev()
	{
		return $this->environment == self::ENV_DEV;
	}

	/**
	 * @return mixed
	 */
	public function getEnvironment()
	{
		return $this->environment;
	}

	/**
	 * @param mixed $environment
	 *
	 * @return Taxify
	 */
	public function setEnvironment( $environment )
	{
		$this->environment = ( $environment == self::ENV_PROD) ? self::ENV_PROD : self::ENV_DEV;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getApiKey()
	{
		return $this->api_key;
	}

	/**
	 * @param mixed $api_key
	 *
	 * @return Taxify
	 */
	public function setApiKey( $api_key )
	{
		$this->api_key = $api_key;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	public static function toString( $string )
	{
		return ($string === NULL) ? '' : $string;
	}

	/**
	 * @return boolean
	 */
	public function isDebugMode()
	{
		return $this->debug_mode;
	}

	/**
	 * @param boolean $debug_mode
	 *
	 * @return Taxify
	 */
	public function setDebugMode( $debug_mode )
	{
		$this->debug_mode = ($debug_mode === TRUE) ? TRUE : FALSE;

		return $this;
	}

	/**
	 * @param $title
	 * @param $data
	 */
	public function printDebugInfo( $title, $data )
	{
		if ( $this->debug_mode == TRUE )
		{
			echo '<h2>&lt;' . $title . '&gt;</h2>' . "\r\n";
			var_dump( $data );
			echo '<h2>&lt;/' . $title . '&gt;</h2>' . "\r\n";
		}
	}
}