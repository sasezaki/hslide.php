<?php
require_once dirname(__FILE__) . '/lib/HatenaSyntax.php';
require_once dirname(__FILE__) . '/lib/Hslide.php';

$slide_text = '';
foreach (glob(dirname(__FILE__) . '/slides/*.txt') as $path) {
    $slide_text .= file_get_contents($path);
}

$hs = new Hslide(dirname(__FILE__) . '/template.php');
echo $hs->render($slide_text);
