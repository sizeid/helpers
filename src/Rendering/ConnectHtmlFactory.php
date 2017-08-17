<?php

namespace SizeID\Helpers\Rendering;

use SizeID\Helpers\Connect;
use SizeID\Helpers\Exceptions\InvalidStateException;

class ConnectHtmlFactory implements ConnectHtmlFactoryInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function create(Connect $connect)
	{
		if (!$connect->getIdentityKey()) {
			throw new InvalidStateException('Connect::identityKey property is required!');
		}
		$template = file_get_contents(__DIR__ . '/templates/connect.txt');
		$replace = "'//connect.sizeid.com', '{$connect->getIdentityKey()}'";
		if ($connect->getCwidFunction()) {
			$replace.= ", {cwidCallback: {$connect->getCwidFunction()}}";
		}
		return str_replace(
			'[PARAMS]',
			$replace,
			$template
		);
	}
}