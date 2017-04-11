<?php

namespace SizeID\Helpers;

/**
 * Representation of https://business.sizeid.com/integration.settings/#button-code
 * @package SizeID\Helpers
 */
class Button
{

	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var integer - in px
	 */
	private $width;

	/**
	 * @var integer - in px
	 */
	private $height;

	/**
	 * @var integer - Size Chart Id
	 */
	private $sizeChart;

	/**
	 * @var string - ISO 639-1 of required language
	 */
	private $language;

	/**
	 * @var boolean - true show size table, false otherwise
	 */
	private $showSizeTable;

	/**
	 * @param array $template - create from api response
	 * @return Button
	 */
	public static function fromTemplate(array $template)
	{
		$new = new static();
		$new->id = $template['id'];
		$new->width = $template['style']['width'];
		$new->height = $template['style']['height'];
		return $new;
	}

	/**
	 * @return array - template for serialization
	 */
	public function getTemplate()
	{
		return [
			'id' => $this->id,
			'style' => [
				'width' => $this->width,
				'height' => $this->height,
			],
		];
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function setWidth($width)
	{
		$this->width = $width;
		return $this;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function setHeight($height)
	{
		$this->height = $height;
		return $this;
	}

	public function getSizeChart()
	{
		return $this->sizeChart;
	}

	public function setSizeChart($sizeChart)
	{
		$this->sizeChart = $sizeChart;
		return $this;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function setLanguage($language)
	{
		$this->language = $language;
		return $this;
	}

	public function getShowSizeTable()
	{
		return $this->showSizeTable;
	}

	public function setShowSizeTable($showSizeTable)
	{
		$this->showSizeTable = $showSizeTable;
		return $this;
	}
}

