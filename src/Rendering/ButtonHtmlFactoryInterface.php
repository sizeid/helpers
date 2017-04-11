<?php

namespace SizeID\Helpers\Rendering;

use SizeID\Helpers\Button;
use SizeID\Helpers\Exceptions\InvalidStateException;

interface ButtonHtmlFactoryInterface
{

	/**
	 * @param Button $button
	 * @return mixed
	 * @throws InvalidStateException
	 */
	public function create(Button $button);
}