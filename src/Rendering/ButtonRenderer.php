<?php

namespace SizeID\Helpers\Rendering;

use SizeID\Helpers\Button;
use SizeID\Helpers\Exceptions\InvalidStateException;

class ButtonRenderer
{

	public function render(Button $button)
	{
		if (!$button->getSizeChart()) {
			throw new InvalidStateException(Button::class . "::sizeChart property is required!");
		}
		$render = new Renderer();
		return $render->renderToString('button', ['button' => $button]);
	}
}