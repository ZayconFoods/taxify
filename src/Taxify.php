<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 10:31 AM
 */

namespace ZayconTaxify;

class Taxify {

	const DEV_URL = 'https://ws-test.shipcompliant.com/taxify/1.1/core/JSONservice.asmx/';
	const PROD_URL = 'https://ws.taxify.co/taxify/1.1/core/JSONService.asmx/';
	const DEV_ENV_NAME = 'DEV';
	const PROD_ENV_NAME = 'PROD';

	private $url;
	private $api_key;
	private $debug_mode = FALSE;

	/**
	 * @param null $api_key
	 * @param bool|FALSE $use_prod
	 * @param bool|FALSE $debug_mode
	 */
	function __construct( $api_key=NULL, $use_prod=FALSE, $debug_mode=FALSE ) {

		if ( $api_key !== NULL )
		{
			$this->setApiKey( $api_key );
		}

		$this->setDebugMode( $debug_mode );

		$this->url = ( $use_prod === TRUE ) ? self::PROD_URL : self::DEV_URL;
	}

	/**
	 * @return bool
	 */
	public function isProd()
	{
		return $this->url == self::PROD_URL;
	}

	/**
	 * @return bool
	 */
	public function isDev()
	{
		return $this->url == self::DEV_URL;
	}

	/**
	 * @return string
	 */
	public function getEnvironment()
	{
		return ($this->url == self::PROD_URL) ? self::PROD_ENV_NAME : self::DEV_ENV_NAME;
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