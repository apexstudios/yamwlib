<?php
namespace YamwLibs\Libs\Html;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 * @package YamwLibs
 */
class HtmlFactory
{
    /**
     * Creates a div tag
     *
     * @param mixed $content
     * @param string $id
     * @param mixed $classes
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function divTag(
        $content = '',
        $id = null,
        $classes = null
    ) {
        $tag = self::createTag('div', $content);

        if ($id) {
            $tag->setId($id);
        }

        if ($classes) {
            $tag->addClass($classes);
        }

        return $tag;
    }

    /**
     * Creates a span tag
     *
     * @param mixed $content
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function spanTag($content = '')
    {
        return self::createTag('span', $content);
    }

    /**
     * Creates a ul tag
     *
     * @param mixed $content
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function ulTag($content = '')
    {
        return self::createTag('ul', $content);
    }

    /**
     * Creates a li tag
     *
     * @param mixed $content
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function liTag($content = '')
    {
        return self::createTag('li', $content);
    }

    public static function button($content = '', $classes = null)
    {
        $tag = self::createTag('button', $content);
        if ($classes) {
            $tag->addClass($classes);
        }
        return $tag;
    }

    public static function pTag($content = '', $classes = null)
    {
        $tag = self::createTag('p', $content);
        if ($classes) {
            $tag->addClass($classes);
        }
        return $tag;
    }

    public static function aTag($label = '', $href = null)
    {
        $tag = self::createTag('a', $label);
        if ($href) {
            $tag->addOption('href', $href);
        }
        return $tag;
    }

    /**
     * Creates a image tag
     *
     * @param string $src
     * @param int $width
     * @param int $height
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    public static function imgTag($src, $width = null, $height = null)
    {
        return self::createTag(
            'img',
            null,
            array(
                'src' => $src,
                'width' => $width,
                'height' => $height
            )
        );
    }

    /**
     * Creates a HtmlTag
     *
     * @param string $name
     * @param mixed $content
     * @param array $options
     *
     * @return \YamwLibs\Libs\Html\Markup\HtmlTag
     */
    private static function createTag(
        $name,
        $content = '',
        array $options = array()
    ) {
        return new Markup\HtmlTag($name, $content, $options);
    }
}
