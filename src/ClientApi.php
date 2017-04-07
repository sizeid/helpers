<?php

namespace SizeID\Helpers;

use GuzzleHttp\Psr7\Request;

class ClientApi extends \SizeID\OAuth2\ClientApi
{

	public function getIdentityKey()
	{
		return $this->clientId;
	}

	public function get($uri)
	{
		$response = $this->send(new Request('get', $uri));
		return json_decode($response->getBody()->getContents(), TRUE)['data'];
	}
}