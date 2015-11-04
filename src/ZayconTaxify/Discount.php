<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 7:55 AM
 */

namespace ZayconTaxify;

class Discount {

	private $order;
	private $code;
	private $amount;
	private $discount_type;

	function __construct ( $order=0, $code='', $amount=0, $discount_type='' )
	{
		$this
			->setOrder( $order )
			->setCode( $code )
			->setAmount( $amount )
			->setDiscountType( $discount_type );
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return array(
			'Discount' => array(
				'Order' => ( is_numeric( $this->order ) ) ? $this->order : 0,
				'Code' => Taxify::toString( $this->code ),
				'Amount' => ( is_numeric( $this->amount ) ) ? $this->amount : 0,
				'DiscountType' => Taxify::toString( $this->discount_type )
			)
		);
	}

	/**
	 * @return mixed
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * @param mixed $order
	 *
	 * @return Discount
	 */
	public function setOrder( $order )
	{
		$order = preg_replace('/[^0-9-]*/', '', $order);
		$this->order = (is_numeric($order)) ? $order : 0;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @param mixed $code
	 *
	 * @return Discount
	 */
	public function setCode( $code )
	{
		$this->code = $code;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param mixed $amount
	 *
	 * @return Discount
	 */
	public function setAmount( $amount )
	{
		$amount = preg_replace('/[^0-9.-]*/', '', $amount);
		$this->order = (is_numeric($amount)) ? $amount : 0;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDiscountType()
	{
		return $this->discount_type;
	}

	/**
	 * @param mixed $discount_type
	 *
	 * @return Discount
	 */
	public function setDiscountType( $discount_type )
	{
		$this->discount_type = $discount_type;

		return $this;
	}
}