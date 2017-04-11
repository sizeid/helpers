<?php

namespace SizeID\Helpers;

/**
 * Representation of https://business.sizeid.com/integration.settings/#connect
 * @package SizeID\Helpers
 */
class Connect
{

	/**
	 * https://business.sizeid.com/integration.settings/#credentials
	 * @var string
	 */
	private $identityKey;

	/**
	 * https://business.sizeid.com/integration.business-api/#cwid
	 * @var string
	 */
	private $cwidFunction;

	public function getIdentityKey()
	{
		return $this->identityKey;
	}

	public function setIdentityKey($identityKey)
	{
		$this->identityKey = $identityKey;
		return $this;
	}

	public function getCwidFunction()
	{
		return $this->cwidFunction;
	}

	public function setCwidFunction($cwidFunction)
	{
		$this->cwidFunction = $cwidFunction;
		return $this;
	}
}