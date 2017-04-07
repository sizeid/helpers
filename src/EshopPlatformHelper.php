<?php

namespace SizeID\Helpers;

use GuzzleHttp\Exception\ClientException;
use SizeID\Helpers\Exceptions\InvalidStateException;
use SizeID\Helpers\Rendering\ButtonRenderer;
use SizeID\Helpers\Rendering\ConnectRenderer;
use SizeID\OAuth2\Api;

class EshopPlatformHelper
{

	/**
	 * @var ClientApi
	 */
	private $clientApi;

	public function __construct(ClientApi $clientApi)
	{
		$this->clientApi = $clientApi;
	}

	public function credentialsAreValid()
	{
		try {
			$this->clientApi->acquireNewAccessToken();
			return TRUE;
		} catch (ClientException $ex) {
			$response = $ex->getResponse();
			if ($response->getStatusCode() === 401 && $response->getHeaderLine(Api::SIZEID_ERROR_CODE_HEADER) == 104) {
				return FALSE;
			}
			throw $ex;
		}
	}

	public function getButtons()
	{
		return $this->clientApi->get('client/advisor-buttons');
	}

	public function getButtonPairs()
	{
		$result = $this->getButtons();
		$buttons = [];
		foreach ($result as $button) {
			$buttons[$button['id']] = $button['name'];
		}
		return $buttons;
	}

	public function getActiveSizeCharts()
	{
		return $this->clientApi->get("client/active-size-charts?limit=1000");
	}

	public function getActiveSizeChartsPairs()
	{
		$result = $this->getActiveSizeCharts();
		$sizeCharts = [];
		foreach ($result as $sizeChart) {
			$sizeCharts[$sizeChart['id']] = implode(
				", ",
				[
					$sizeChart['brand'],
					$sizeChart['gender']['label'],
					implode(
						', ',
						array_map(
							function ($category) {
								return $category['label'];
							},
							$sizeChart['categories']
						)
					),
					$sizeChart['type'],
					$sizeChart['id'],
				]
			);
		}
		return $sizeCharts;
	}

	/**
	 * @return Button
	 */
	public function getDefaultButton()
	{
		$buttons = $this->getButtons();
		return Button::fromTemplate(reset($buttons));
	}

	/**
	 * @return Button
	 */
	public function getButtonById($id)
	{
		foreach ($this->getButtons() as $button) {
			if ($button['id'] == $id) {
				return Button::fromTemplate($button);
			}
		}
		throw  new InvalidStateException("Button '$id' not found!");
	}

	public function getAvailableLanguages()
	{
		return [
			'cs', 'de', 'en', 'hu', 'pl', 'ro', 'sk',
		];
	}

	public function isSupportedLanguage($requiredLanguageIso)
	{
		return in_array($requiredLanguageIso, $this->getAvailableLanguages());
	}

	/**
	 * @return Connect
	 */
	public function createConnect()
	{
		$connect = new Connect();
		$connect->setIdentityKey($this->clientApi->getIdentityKey());
		return $connect;
	}

	public function renderConnect(Connect $connect = NULL)
	{
		if ($connect === NULL) {
			$connect = $this->createConnect();
		}
		$connectRenderer = new ConnectRenderer();
		return $connectRenderer->render($connect);
	}

	public function renderButton(Button $button)
	{
		if (!$this->isSupportedLanguage($button->getLanguage())) {
			$button->setLanguage(NULL);
		}
		$buttonRenderer = new ButtonRenderer();
		return $buttonRenderer->render($button);
	}
}