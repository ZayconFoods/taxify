<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 10:56 AM
 */

namespace ZayconDev;

class Communicator {

	/** @var Taxify $taxify */
	private $taxify;

	/**
	 * @param Taxify $taxify
	 */
	function __construct(Taxify &$taxify) {

		$this->taxify = $taxify;
	}

	/**
	 * @param $service
	 * @param $json
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function call( $service, $json ) {

		$ch = curl_init();

		curl_setopt_array( $ch, array(
			CURLOPT_URL => $this->taxify->getUrl() . $service,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER => TRUE,
			CURLOPT_POST => TRUE,
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Content-Length: '. strlen($json)
			)
		));

		$result = curl_exec( $ch );
		$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );

		if ( $http_code != 200 )
		{
			throw new Exception ( Exception::ERROR_COMMUNICATION . ' (' . $this->taxify->getUrl() . ')' );
		}

		return $result;
	}
}