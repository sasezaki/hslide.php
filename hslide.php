<?php
require_once dirname(__FILE__) . '/lib/HatenaSyntax.php';
require_once dirname(__FILE__) . '/lib/Hslide.php';

if (!isset($_GET['theme'])) {
    $themes = glob(dirname(__FILE__) . '/theme/*');
    foreach ($themes as $i => $theme) {
        $themes[$i] = substr($theme, strlen(dirname(__FILE__) . '/theme/'));
    }
    require_once dirname(__FILE__) . '/template/index.php';
    exit;
}

$themeName = isset($_GET['theme']) ? $_GET['theme'] : 'default';

$text = '';
$textFiles = glob(dirname(__FILE__) . '/slide/*.txt');
natsort($textFiles);
foreach ($textFiles as $path) {
    $text .= file_get_contents($path);
}

$hs = new Hslide(dirname(__FILE__), $themeName);
echo $hs->render($text);

