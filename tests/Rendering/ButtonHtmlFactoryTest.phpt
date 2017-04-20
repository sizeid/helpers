<?php

namespace SizeID\Helpers\Rendering\Tests;

use SizeID\Helpers\Button;
use SizeID\Helpers\Rendering\ButtonHtmlFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class ButtonHtmlFactoryTest extends TestCase
{

	public function testCreate()
	{
		$button = new Button();
		$button
			->setId(1)
			->setWidth(100)
			->setHeight(25)
			->setLanguage('cs')
			->setShowSizeTable(TRUE);
		$buttonHtmlFactory = new ButtonHtmlFactory();
		Assert::exception(
			function () use ($buttonHtmlFactory, $button) {
				$buttonHtmlFactory->create($button);
			},
			'SizeID\Helpers\Exceptions\InvalidStateException'
		);
		$button->setSizeChart(42);
		Assert::equal(
			'<div class="SizeID-button" data-sizeid-size-chart="42" style="width:100px;height:25px;" data-sizeid-button-style="1" data-sizeid-language="cs" data-sizeid-show-size-table="1"></div>',
			(string)$buttonHtmlFactory->create($button)
		);
	}
}

$test = new ButtonHtmlFactoryTest();
$test->run();
