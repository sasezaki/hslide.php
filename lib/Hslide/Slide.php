<?php

class Hslide_Slide 
{
    protected $html, $title;

    function __construct($html, $title) 
    {
        $this->html = $html;
        $this->title = $title;
    }

    function getHtml()
    {
        return $this->html;
    }

    function getTitle()
    {
        return $this->title;
    }
}
