<?php

namespace SizeID\Helpers\Rendering;

use Nette\Utils\Html;
use SizeID\Helpers\Connect;
use SizeID\Helpers\Exceptions\InvalidStateException;

interface ConnectHtmlFactoryInterface
{

	/**
	 * @param Connect $connect
	 * @return Html
	 * @throws InvalidStateException
	 */
	public function create(Connect $connect);
}