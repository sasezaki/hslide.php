<?php
require_once dirname(__FILE__) . '/lib/HatenaSyntax.php';
require_once dirname(__FILE__) . '/lib/Hslide.php';

$themeName = isset($_GET['theme']) ? $_GET['theme'] : 'default';

$text = '';
$textFiles = glob(dirname(__FILE__) . '/slide/*.txt');
natsort($textFiles);
foreach ($textFiles as $path) {
    $text .= file_get_contents($path);
}

$hs = new Hslide(dirname(__FILE__), $themeName);
echo $hs->render($text);

