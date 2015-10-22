<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 10:56 AM
 */

namespace ZayconTaxify;

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
	 * @param $data
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function call( $service, $data ) {

		$envelope = array(
			$service => array_merge(
				array(
					'Security' => array(
						'Password' => $this->taxify->getApiKey()
					)
				),
				$data
			)
		);

		$json = json_encode( $envelope );

		$this->taxify->printDebugInfo( 'Envelope', $envelope );
		$this->taxify->printDebugInfo( 'JSON', $json );

		$ch = curl_init();

		curl_setopt_array( $ch, array(
			CURLOPT_URL => $this->taxify->getUrl() . $service,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER => FALSE,
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

		$this->taxify->printDebugInfo( 'Result', $result );

		if ( $http_code != 200 )
		{
			throw new Exception ( Exception::ERROR_COMMUNICATION . ' (' . $this->taxify->getUrl() . $service . ')' );
		}

		$array = json_decode( $result, TRUE );

		if ( ! array_key_exists( 'd', $array ) )
		{
			throw new Exception ( Exception::ERROR_CALL );
		}

		$array = $array['d'];

		if ( ! isset( $array['ResponseStatus'] ) || $array['ResponseStatus'] != 1 )
		{
			if ( isset( $array['Errors'] ) && count( $array['Errors'] ) > 0 )
			{
				throw new Exception( $array['Errors'][0]['Message'], $array['Errors'][0]['Code'] );
			}

			throw new Exception( 'Unknown Error' );
		}

		return $array;
	}
}