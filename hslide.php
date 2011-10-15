<?php
require_once __DIR__ . '/lib/HatenaSyntax.php';
require_once __DIR__ . '/lib/Hslide.php';

$slide_text = '';
foreach (glob(__DIR__ . '/slides/*.txt') as $path) {
    $slide_text .= file_get_contents($path);
}

$hs = new Hslide(__DIR__ . '/template.php');
echo $hs->render($slide_text);
