<?php

namespace SizeID\Helpers\Tests;

use GuzzleHttp\Psr7\Response;
use Mockery as m;
use SizeID\Helpers\ClientApi;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

class ClientApiTest extends TestCase
{

	public function testGet()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi->makePartial();
		$clientApi->setApiLanguage('xx');
		$clientApi->getIdentityKey();
		$response = new Response(200, [], '{"data": {}}');
		$clientApi
			->shouldReceive('send')
			->andReturn($response);
		Assert::equal([], $clientApi->get('api'));
	}

}

$test = new ClientApiTest();
$test->run();
