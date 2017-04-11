<?php
use Latte\Engine;
use SizeID\Helpers\ClientApi;
use SizeID\Helpers\EshopPlatformHelper;

require __DIR__ . '/bootstrap.php';
// create helpers CLIENT_ID and CLIENT_SECRET from config.php
$helper = new EshopPlatformHelper(new ClientApi(CLIENT_ID, CLIENT_SECRET));
// template rendering engine
$engine = new Engine();
// check client credentials
if (!$helper->credentialsAreValid()) {
	echo "invalid credentials";
	die;
}
if (!isset($_GET['sizeChart'])) {
	// render button and size chart selection
	$engine->render(
		__DIR__ . '/select.latte',
		[
			'sizeCharts' => $helper->getActiveSizeChartsPairs(),
			'buttons' => $helper->getButtonPairs(),
		]
	);
	die;
} else {
	// render SizeID Button with selected style and size chart
	if (isset($_GET['button'])) {
		$button = $helper->getButtonById($_GET['button']);
	} else {
		$button = $helper->getDefaultButton();
	}
	$button->setSizeChart($_GET['sizeChart']);
	$engine->render(
		'example.latte',
		[
			'button' => $helper->renderButton($button),
			'connect' => $helper->renderConnect(),
		]
	);
	die;
}

