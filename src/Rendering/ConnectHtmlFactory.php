<?php

namespace SizeID\Helpers\Rendering;

use Nette\Utils\Html;
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
			throw new InvalidStateException(Connect::class . '::identityKey property is required!');
		}
		$script = Html::el(
			'script',
			[
				'id' => 'SizeID-script',
				'src' => '//connect.sizeid.com',
				'data-sizeid-identity-key' => $connect->getIdentityKey(),
			]
		);
		if ($connect->getCwidFunction()) {
			$script->addAttributes(
				[
					'data-sizeid-cwid-function' => $connect->getCwidFunction(),
				]
			);
		}
		return $script;
	}
}