<?php

namespace SizeID\Helpers\Rendering;

use SizeID\Helpers\Button;
use SizeID\Helpers\Exceptions\InvalidStateException;

class ButtonHtmlFactory implements ButtonHtmlFactoryInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function create(Button $button)
	{
		if (!$button->getSizeChart()) {
			throw new InvalidStateException('Button::sizeChart property is required!');
		}
		$attributes = [
			'class' => 'SizeID-button',
			'data-sizeid-size-chart' => $button->getSizeChart(),
		];
		$style = "";
		if ($button->getWidth()) {
			$style .= "width:{$button->getWidth()}px;";
		}
		if ($button->getHeight()) {
			$style .= "height:{$button->getHeight()}px;";
		}
		if ($style) {
			$attributes['style'] = $style;
		}
		if ($button->getId() !== NULL) {
			$attributes['data-sizeid-button-style'] = $button->getId();
		}
		if ($button->getLanguage()) {
			$attributes['data-sizeid-language'] = $button->getLanguage();
		}
		if ($button->getShowSizeTable()) {
			$attributes['data-sizeid-show-size-table'] = (int)$button->getShowSizeTable();
		}
		return Html::el('div', $attributes);
	}
}