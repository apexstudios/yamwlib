<?php
namespace YamwLibs\Infrastructure\Templater\Markup;

/**
 * Markup capable of invoking a method or function, so you do not have to use
 * `eval()`.
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Templater
 */
class MethodInvocationMarkup extends AbstractTemplateMarkup
{
    private $name;
    private $method = array();
    private $pattern;
    private $critical;

    /**
     * Constructs a MethodInvocationMarkup
     *
     * @param type $name
     * The name of this markup
     *
     * @param type $pattern
     * The pattern according to which the replacement is being fulfilled
     *
     * @param array $method
     * An array describing the method invocation. It should contain two
     * elements:
     *
     * The first element describes the method that is to be invoked. It may be a
     * string with the name of the function, or an array with the first element
     * being the object containing the method or a class name with the method.
     *
     * The second element should contain an array with the parameters. Supply
     * an empty array in case the method should be invoked with no parameters.
     *
     * This is the same syntax as `call_user_func_array()`, except that its
     * arguments are to be supplied together in an array.
     *
     * @param type $critical
     * Whether this markup is critical or not
     */
    public function __construct(
        $name,
        $pattern,
        array $method,
        $critical = false
    ) {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->critical = $critical;

        // Check whether $method is valid

        // We only accept arrays with two elements - no left-outs
        if (count($method) === 2) {
            if (is_array($method[0])) {
                if (
                    is_object($method[0][0]) ||
                    (!is_object($method[0][0]) && class_exists($method[0][0]))
                ) {
                    if (!method_exists($method[0][0], $method[0][1])) {
                        self::invalidMethod();
                    }
                }
            } elseif (!is_array($method[0]) && !function_exists($method[0])) {
                self::invalidMethod();
            }

            if (!is_array($method[1])) {
                self::invalidMethod();
            }
        } else {
            self::invalidMethod();
        }

        $this->method = $method;
    }

    private static function invalidMethod()
    {
        throw new \RuntimeException('The supplied method array is invalid');
    }

    public function getContent()
    {
        /*
         * To understand recursiveness,
         * you first have to understand recursiveness
         *
         * Resolves to
         *     call_user_func_array(
         *         $this->method[0],
         *         $this->method[1]
         *     );
         */
        return call_user_func_array('call_user_func_array', $this->method);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function isCritical()
    {
        return $this->critical;
    }
}
