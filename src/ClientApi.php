<?php

namespace SizeID\Helpers;

use GuzzleHttp\Message\Request;

class ClientApi extends \SizeID\OAuth2\ClientApi
{

	private $language = 'en';

	/**
	 * @param $language ISO 639-1 code of api response language
	 */
	public function setApiLanguage($language)
	{
		$this->language = $language;
	}

	public function getIdentityKey()
	{
		return $this->clientId;
	}

	public function get($uri)
	{
		$response = $this->send(new Request('get', $uri, ['Accept-Language' => $this->language]));
		return json_decode($response->getBody()->getContents(), TRUE)['data'];
	}
}