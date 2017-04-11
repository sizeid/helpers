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

	/**
	 * Checks connection to SizeID Business API.
	 * @return boolean true - connection ok, false otherwise
	 */
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

	/**
	 * Calls https://business.sizeid.com/integration.business-api/client-advisor-buttons and return $.data as
	 * array.
	 * @return array
	 */
	public function getButtons()
	{
		return $this->clientApi->get('client/advisor-buttons');
	}

	/**
	 * Calls https://business.sizeid.com/integration.business-api/client-advisor-buttons and return flat associative
	 * array. associative array.
	 * key = $.data.id
	 * value = $.data.name
	 * @return array
	 */
	public function getButtonPairs()
	{
		$result = $this->getButtons();
		$buttons = [];
		foreach ($result as $button) {
			$buttons[$button['id']] = $button['name'];
		}
		return $buttons;
	}

	/**
	 * Calls https://business.sizeid.com/integration.business-api/active-size-chart-collection and return
	 * $.data as array
	 * @return array
	 */
	public function getActiveSizeCharts()
	{
		return $this->clientApi->get("client/active-size-charts?limit=1000");
	}

	/**
	 * Calls https://business.sizeid.com/integration.business-api/active-size-chart-collection and return flat
	 * associative array.
	 * key = $.data.id
	 * value = formatted label - e.g. Nike, Male, Upper Body, All garments, 39
	 * @return array
	 */
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

	/**
	 * @return array - languages supported by SizeID in ISO 639-1
	 */
	public function getAvailableLanguages()
	{
		return [
			'cs', 'de', 'en', 'hu', 'pl', 'ro', 'sk',
		];
	}

	/**
	 * @param $language
	 * @return bool true if supported, else otherwise
	 */
	public function isSupportedLanguage($language)
	{
		return in_array($language, $this->getAvailableLanguages());
	}

	/**
	 * Creates object representation of SizeID Connect script
	 * (https://business.sizeid.com/integration.settings/#connect)
	 * @return Connect
	 */
	public function createConnect()
	{
		$connect = new Connect();
		$connect->setIdentityKey($this->clientApi->getIdentityKey());
		return $connect;
	}

	/**
	 * Renders SizeID Connect (https://business.sizeid.com/integration.settings/#connect) script to html.
	 * @param Connect|NULL $connect - if null default configuration of connect will be used
	 * @return html of connect
	 */
	public function renderConnect(Connect $connect = NULL)
	{
		if ($connect === NULL) {
			$connect = $this->createConnect();
		}
		$connectRenderer = new ConnectRenderer();
		return $connectRenderer->render($connect);
	}

	/**
	 * Renders SizeID Button (https://business.sizeid.com/integration.advisor/#button-code) to html.
	 * @param Button $button
	 * @return html of button
	 */
	public function renderButton(Button $button)
	{
		if (!$this->isSupportedLanguage($button->getLanguage())) {
			$button->setLanguage(NULL);
		}
		$buttonRenderer = new ButtonRenderer();
		return $buttonRenderer->render($button);
	}
}