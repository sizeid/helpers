<?php
use Latte\Engine;
use SizeID\Helpers\ClientApi;
use SizeID\Helpers\EshopPlatformHelper;

require __DIR__ . '/bootstrap.php';
$helper = new EshopPlatformHelper(new ClientApi(CLIENT_ID, CLIENT_SECRET));
$engine = new Engine();
if (!$helper->credentialsAreValid()) {
	echo "invalid credentials";
	die;
}
if (!isset($_GET['sizeChart'])) {
	$engine->render(
		__DIR__ . '/select.latte',
		[
			'sizeCharts' => $helper->getActiveSizeChartsPairs(),
			'buttons' => $helper->getButtonPairs(),
		]
	);
	die;
} else {
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

