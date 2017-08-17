<?php

namespace SizeID\Helpers\Rendering\Tests;

use SizeID\Helpers\Connect;
use SizeID\Helpers\Rendering\ConnectHtmlFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class ConnectHtmlFactoryTest extends TestCase
{

	public function testCreate()
	{
		$connect = new Connect();
		$connectHtmlFactory = new ConnectHtmlFactory();
		Assert::exception(
			function () use ($connectHtmlFactory, $connect) {
				$connectHtmlFactory->create($connect);
			},
			'SizeID\Helpers\Exceptions\InvalidStateException'
		);
		$connect
			->setIdentityKey('ik')
			->setCwidFunction('function(d){console.log(d);}');

		Assert::equal(
			file_get_contents(__DIR__.'/connect.txt'),
			(string)$connectHtmlFactory->create($connect)
		);
	}
}

$test = new ConnectHtmlFactoryTest();
$test->run();
