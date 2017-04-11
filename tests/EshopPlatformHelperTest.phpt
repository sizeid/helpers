<?php

namespace SizeID\Helpers\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use SizeID\Helpers\Button;
use SizeID\Helpers\ClientApi;
use SizeID\Helpers\EshopPlatformHelper;
use SizeID\Helpers\Exceptions\InvalidStateException;
use SizeID\Helpers\Rendering\ButtonHtmlFactoryInterface;
use SizeID\Helpers\Rendering\ConnectHtmlFactoryInterface;
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
			function () use ($helper) {
				$helper->credentialsAreValid();
			},
			ClientException::class
		);
	}

	public function testGetButtonPairs()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi->shouldReceive('get')
			->andReturn($this->createButtonResponse());
		$helper = new EshopPlatformHelper($clientApi);
		Assert::equal([1 => 'style1'], $helper->getButtonPairs());
	}

	public function testGetActiveSizeChartsPairs()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi->shouldReceive('get')
			->andReturn(
				[
					[
						'id' => 'id',
						'gender' => ['label' => 'gender'],
						'brand' => 'brand',
						'type' => 'type',
						'categories' => [
							[
								'label' => 'c1',
							],
							[
								'label' => 'c2',
							],
						],
					],
				]
			);
		$helper = new EshopPlatformHelper($clientApi);
		Assert::equal(['id' => 'brand, gender, c1, c2, type, id'], $helper->getActiveSizeChartsPairs());
	}

	public function testGetDefaultButton()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi
			->shouldReceive('get')
			->andReturn($this->createButtonResponse());
		$helper = new EshopPlatformHelper($clientApi);
		Assert::type(Button::class, $helper->getDefaultButton());
	}

	public function testGetButtonById()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi
			->shouldReceive('get')
			->andReturn($this->createButtonResponse());
		$helper = new EshopPlatformHelper($clientApi);
		Assert::type(Button::class, $helper->getButtonById(1));
		Assert::exception(
			function () use ($helper) {
				$helper->getButtonById(2);
			},
			InvalidStateException::class,
			"Button '2' not found!"
		);
	}

	public function testIsSupportedLanguage()
	{
		$clientApi = m::mock(ClientApi::class);
		$helper = new EshopPlatformHelper($clientApi);
		Assert::false($helper->isSupportedLanguage('xx'));
		Assert::true($helper->isSupportedLanguage('cs'));
	}

	public function testRenderConnect()
	{
		$clientApi = m::mock(ClientApi::class);
		$clientApi
			->shouldReceive('getIdentityKey')
			->andReturn('ik');
		$connectHtmlFactory = m::mock(ConnectHtmlFactoryInterface::class);
		$connectHtmlFactory
			->shouldReceive('create')
			->andReturn('');
		$helper = new EshopPlatformHelper($clientApi, $connectHtmlFactory);
		Assert::equal('', $helper->renderConnect());
	}

	public function testRenderButton()
	{
		$clientApi = m::mock(ClientApi::class);
		$buttonHtmlFactory = m::mock(ButtonHtmlFactoryInterface::class);
		$buttonHtmlFactory
			->shouldReceive('create')
			->andReturn('');
		$helper = new EshopPlatformHelper($clientApi, NULL, $buttonHtmlFactory);
		Assert::equal('', $helper->renderButton(new Button()));
	}

	private function createButtonResponse()
	{
		return [
			[
				'id' => 1,
				'name' => 'style1',
				'style' => [
					'width' => 50,
					'height' => 20,
				],
			],
		];
	}
}

$test = new EshopPlatformHelperTest();
$test->run();
