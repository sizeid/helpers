<?php

namespace SizeID\Helpers;

class Connect
{

	private $identityKey;

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