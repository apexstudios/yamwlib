<?php
namespace YamwLibs\Libs\Text\Strings;

/**
 * Provides a flexible and dynamic ability to choose variants of a text string
 * from text providers
 *
 * Useful for translation
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Text
 */
class TextString
{
    /**
     * The name identifier of this string
     *
     * @var string
     */
    private $name;

    /**
     * Holds the args for this string
     *
     * @var array
     */
    private $args;

    public function __construct()
    {
        $args = func_get_args();

        if (is_array($args[0])) {
            $params = $args[0];
        } else {
            $params = $args;
        }

        $this->name = array_shift($params);

        $this->args = count($params) ? $params : array();
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        $args = array_merge(array($this->name), $this->args);
        $string = call_user_func_array(
            'sprintf',
            $args
        );

        return $string ?: "";
    }
}
