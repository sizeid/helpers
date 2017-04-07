<?php

namespace SizeID\Helpers\Rendering;

use SizeID\Helpers\Connect;
use SizeID\Helpers\Exceptions\InvalidStateException;

class ConnectRenderer
{

	public function render(Connect $connect)
	{
		if (!$connect->getIdentityKey()) {
			throw new InvalidStateException(Connect::class . '::identityKey property is required!');
		}
		$renderer = new Renderer();
		return $renderer->renderToString('connect', ['connect' => $connect]);
	}
}