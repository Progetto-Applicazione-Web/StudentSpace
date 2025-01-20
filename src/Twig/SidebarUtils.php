<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SidebarUtils extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('BuildItem', [$this, 'getItem'])
        ];
    }


    /**
     * Generates the HTML for a single menu item.
     *
     * @param string $name - Name of the item.
     * @param array $options - Styles for the item.
     * @param bool $selected
     * @return string - HTML for the item.
     */
    public function getItem(string $name, array $options) : string
    {
        $style = $options['style'];
        $icon = $options['icon'];

        $iconPath = $icon['path'];
        $iconAlt = $icon['alt'];

        $itemStyle= $style['item'];
        $iconStyle = $style['icon'];
        $nameStyle = $style['name'];

        $url = $options["url"];

        return "<a class=\"$itemStyle\" href=\"$url\">
                    <img class=\"$iconStyle\" src=\"$iconPath\" alt=\"$iconAlt\"/>
                    <p class=\"$nameStyle\">$name</p>
                </a>";
    }
}
