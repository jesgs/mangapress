<?php


namespace MangaPress\Theme;

use MangaPress\Component;

/**
 * Class TemplateLoader
 * @package MangaPress\Theme
 */
class TemplateLoader implements Component
{
    public function init()
    {
        add_filter('template_include', [$this, 'template_loader']);
    }

    public function template_loader()
    {
        //
    }
}