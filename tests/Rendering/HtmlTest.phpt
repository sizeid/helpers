<?php

namespace SizeID\Helpers\Rendering\Tests;

use SizeID\Helpers\Rendering\Html;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class HtmlTest extends TestCase
{

	public function testEl()
	{
		Assert::equal('<div></div>', Html::el('div', []));
		Assert::equal('<div one="one" two="two"></div>', Html::el('div', ['one' => 'one', 'two' => 'two']));
	}
}

$test = new HtmlTest();
$test->run();
