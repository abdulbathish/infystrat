<?php
	require_once('captcha.inc.php');
	$aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
	$oVisualCaptcha = new PhpCaptcha($aFonts, CAPTCHA_WIDTH, CAPTCHA_HEIGHT);
	$oVisualCaptcha->Create();
?>