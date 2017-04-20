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
		$attributes =
			[
				'id' => 'SizeID-script',
				'src' => '//connect.sizeid.com',
				'data-sizeid-identity-key' => $connect->getIdentityKey(),
			];
		if ($connect->getCwidFunction()) {
			$attributes['data-sizeid-cwid-function'] = $connect->getCwidFunction();
		}
		return Html::el('script', $attributes);
	}
}