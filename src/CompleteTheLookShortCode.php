<?php

namespace Shopeo\CompleteTheLook;
class CompleteTheLookShortCode
{
    public function __construct()
    {
        add_shortcode('complete-the-look', array($this, 'render'));
    }

    public function render($atts = [], $content = null)
    {
        $body = '';

        return $body;
    }
}