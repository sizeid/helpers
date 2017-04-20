<?php

namespace SizeID\Helpers\Tests;

use SizeID\Helpers\Button;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

class ButtonTest extends TestCase
{

	public function testGet()
	{
		$template = [
			'id' => 1,
			'style' => [
				'width' => 1,
				'height' => 2,
			],
		];
		$button = Button::fromTemplate($template);
		Assert::type('SizeID\Helpers\Button', $button);
		Assert::equal($template, $button->getTemplate());
	}
}

$test = new ButtonTest();
$test->run();
