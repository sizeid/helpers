<?php

namespace SizeID\Helpers\Rendering\Tests;

use SizeID\Helpers\Connect;
use SizeID\Helpers\Exceptions\InvalidStateException;
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
			InvalidStateException::class
		);
		$connect
			->setIdentityKey('ik')
			->setCwidFunction('cwid');
		Assert::equal(
			'<script id="SizeID-script" src="//connect.sizeid.com" data-sizeid-identity-key="ik" data-sizeid-cwid-function="cwid"></script>',
			(string)$connectHtmlFactory->create($connect)
		);
	}
}

$test = new ConnectHtmlFactoryTest();
$test->run();
