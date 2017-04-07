<?php

namespace SizeID\Helpers;

class Button
{

	private $id;

	private $width;

	private $height;

	private $sizeChart;

	private $language;

	private $showSizeTable;

	public static function fromTemplate(array $template)
	{
		$new = new static();
		$new->id = $template['id'];
		$new->width = $template['style']['width'];
		$new->height = $template['style']['height'];
		return $new;
	}

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

