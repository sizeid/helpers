<?php

namespace SizeID\Helpers\Tests;

use GuzzleHttp\Message\Response;
use Mockery as m;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

class ClientApiTest extends TestCase
{

	public function testGet()
	{
		$clientApi = m::mock('SizeID\Helpers\ClientApi');
		$clientApi->makePartial();
		$clientApi->setApiLanguage('xx');
		$clientApi->getIdentityKey();
		$stream = m::mock('GuzzleHttp\Stream\StreamInterface');
		$stream
			->shouldReceive('getContents')
			->andReturn('{"data": {}}');
		$response = new Response(200, [], $stream);
		$clientApi
			->shouldReceive('send')
			->andReturn($response);
		Assert::equal([], $clientApi->get('api'));
	}
}

$test = new ClientApiTest();
$test->run();
