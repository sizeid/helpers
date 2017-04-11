<?php

namespace SizeID\OAuth2\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use SizeID\Helpers\ClientApi;
use SizeID\Helpers\EshopPlatformHelper;
use SizeID\OAuth2\Api;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

class EshopPlatformHelperTest extends TestCase
{

	public function testCredentialsAreValid()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi
			->shouldReceive('acquireNewAccessToken')
			->once();
		$helper = new EshopPlatformHelper($clientApi);
		Assert::true($helper->credentialsAreValid());
		$exception = m::mock(ClientException::class);
		$response = new Response(401, [Api::SIZEID_ERROR_CODE_HEADER => 104]);
		$exception
			->shouldReceive('getResponse')
			->andReturn($response)
			->once();
		$clientApi
			->shouldReceive('acquireNewAccessToken')
			->andThrow($exception)
			->once();
		Assert::false($helper->credentialsAreValid());
		$exception = m::mock(ClientException::class);
		$response = new Response(403);
		$exception
			->shouldReceive('getResponse')
			->andReturn($response)
			->once();
		$clientApi
			->shouldReceive('acquireNewAccessToken')
			->andThrow($exception)
			->once();
		Assert::exception(
			function () use ($helper){
				$helper->credentialsAreValid();
			},
			ClientException::class
		);
	}
}

$test = new EshopPlatformHelperTest();
$test->run();
