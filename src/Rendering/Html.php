<?php

namespace SizeID\Helpers\Rendering;

class Html
{

	public static function el($name, $attributes = [])
	{
		$el = "<$name";
		foreach ($attributes as $key => $value) {
			$el .= " $key=\"$value\"";
		}
		$el .= "></$name>";
		return $el;
	}
}