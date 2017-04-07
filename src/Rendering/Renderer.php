<?php

namespace SizeID\Helpers\Rendering;

use Latte\Engine;

class Renderer
{

	public function renderToString($template, $parameters = [])
	{
		$engine = new Engine();
		return $engine->renderToString(__DIR__ . "/templates/$template.latte", $parameters);
	}
}