<?php
namespace YamwLibs\Libs\Html;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class HtmlFactory
{
    /**
     * Creates a div tag
     *
     * @param type $content
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function divTag($content = '')
    {
        return self::createTag('div', $content);
    }

    /**
     * Creates a span tag
     *
     * @param type $content
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function spanTag($content = '')
    {
        return self::createTag('span', $content);
    }

    /**
     * Creates a image tag
     *
     * @param type $src
     * @param type $width
     * @param type $height
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function imgTag($src, $width = null, $height = null)
    {
        return self::createTag('img', null, array('src' => $src, 'width' => $width, 'height' => $height));
    }

    /**
     * Creates a HtmlTag
     *
     * @param type $name
     * @param type $content
     * @param array $options
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    private static function createTag($name, $content = '', array $options = array())
    {
        return new Markup\HtmlTag($name, $content, $options);
    }
}
